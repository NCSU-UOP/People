<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Student;
use LdapRecord\Models\ActiveDirectory\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\EntryRejectionMail;
use App\Mail\SetPasswordMail;
use App\Models\Batch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use Illuminate\Support\Arr;

class StudentController extends Controller
{
    protected $messages = [
        'required' => 'The :attribute field is required.',
        'same' => 'The :attribute and :other must match.',
        'size' => 'The :attribute must be exactly :size.',
        'min' => 'The :attribute must be greater than :min characters.',
        'max' => 'The :attribute must be less than :max characters.',
        'between' => 'The :attribute value :input is not between :min - :max.',
        'in' => 'The :attribute must be one of the following types: :values',
        'unique' => 'The :attribute is already in use.',
        'exists' => 'The :attribute is invalid.',
        'regex' => 'The :attribute format is invalid.',
        'email' => 'Invalid email.',
        'string' => 'The :attribute should be a string.',
    ];

    /**
     * password setting function
     */
    public function setPassword($username)
    {
        $user = \App\Models\User::where('username', $username)->firstOrfail();

        if(!($user->password_set))
        {
            return view('password.create', compact('username'));
        }

        abort(419);
        
    }

    //updating the password field 
    public function updatePassword($username)
    {
        $data = request()->validate([
            'password' => [
                'required', 
                'string', 
                Password::min(8)
                 ->mixedcase()
                 ->numbers()
                 ->symbols(), 
                'max:'.env("USERS_PASSWORD_MAX"), 
                'confirmed'],
        ], $this->messages);

        $user = \App\Models\User::where('username', $username)->first();

        if(!($user->password_set))
        {
            $student = $user->students()->first();

            $DN_Level = "CN=".$user->username.", OU=".$student->batch_id.", OU=Undergraduate, OU=Students, OU=".$student->faculty()->firstOrfail()->name.", ".env('LDAP_BASE_DN');            

            try {
                
                $adUser = User::find($DN_Level);
                $adUser->unicodepwd=$data['password'];
                $adUser->useraccountcontrol=512;
                $adUser->save();

            } catch (\Throwable $th) {
                abort(500, 'Error{$th}');
            }
            

            $data['password'] = Hash::make($data['password']);
            $data['password_set'] = true;
            $user->update($data);

            return redirect('/');
        }
        
        abort(419);
    }

    /**
     * Show user information to the admin to verify them
     */
    public function getStudent($userId){
        // dd($userId);
        $student = Student::where('id', $userId)->firstOrfail();
        $user = $student->user()->firstOrfail();
        $student->username = $user->username;
        $student->email = $user->email;

        $faculty = $student->faculty()->firstOrfail();
        $deptName = $student->department()->firstOrfail()->name;
        // dd($student);

        $reasons = ["Profile Picture not acceptable", "RegNo/Name mismatch", "Initial/Fullname mismatch", "Wrong Department", "Other"];

        return view('admin.unverifiedStudent', compact('student', 'deptName', 'faculty', 'reasons'));
    }

    /**
     * show all the students of respective batch of the faculty
     */
    public function getStudentList($facultyCode, $batchId){
        // To check the given batch id is in the table batches
        $batch = Batch::where('id', $batchId)->firstOrfail()->id;
        
        $faculty = Faculty::where('code', $facultyCode)->firstOrfail();
        $studentList = $faculty->students()->select('students.id','students.regNo','students.initial','students.image')->where([['students.is_verified', 0], ['students.is_rejected', 0], ['students.batch_id', $batchId]])->get();
        $facultyName = Faculty::where('code', $facultyCode)->firstOrFail()->name;
        
        return view('admin.unverifiedStudentList',compact('studentList','batchId','facultyName', 'facultyCode'));
    }

    /**
     * This route is used to verify user information
     */
    public function verifyStudent($userId){
        // dd($userId);
        $student = Student::where('id', $userId)->firstOrfail();
        $facultyCode = $student->faculty()->firstOrfail()->code;

        if($student->is_verified == 0 && $student->is_rejected == 0) {
            $user = $student->user()->firstOrfail();
            
            try {
                // Create new user in the AD
                $this->createStudentAD($user, $student);
    
                // If AD user creates successfully, then the user will be verified in the local database
                $student->is_verified = 1;
                $student->save();

            } catch (\Throwable $th) {
                abort(500, 'Unable to verify at the moment!');
            }

            //Mail sending procedure
            try {
                Mail::to($user['email'])->send(new SetPasswordMail($user->username));
            } catch (\Throwable $th) {
                // If failed to send the mail, user won't be verified.
                $student->is_verified = 0;
                $student->save();

                /**
                 * AD user will be deleted if possible.
                 * If this is failed, nothing to worrie because the next time all the user attributes will be updated accordingly.
                 */
                try {
                    $this->deleteStudentAD($user, $student);
                } catch(\Throwable $th) {}
            }
            
            return redirect()->route('getStudentList', ['facultyCode' => $facultyCode, 'batchId' => $student->batch_id])->with('message', 'Profile verified Succesfully!!');
        }

        // Abort as a bad request
        abort(400);
    }

    /**
     * Put student data into AD
     * NOTE: This function should be called inside a try catch block.
     */
    private function createStudentAD($user, $student)
    {
        $DN_Level = "CN=".$user->username.", OU=".$student->batch_id.", OU=Undergraduate, OU=Students, OU=".$student->faculty()->firstOrfail()->name.", ".env('LDAP_BASE_DN');

        $adUser = User::find($DN_Level);

        // If the user is not already in the AD, a new user will be created.
        if(!$adUser) {
            $adUser = new User();
        }

        /**
         * Initialize/Update the user attributes depending on the user's existance in the AD
         */
        $adUser->cn = $user->username;
        $adUser->mail = $user->email;
        $adUser->sAMAccountName = $user->username;
        $adUser->userPrincipalName = $user->username;
        $adUser->displayName = $student->regNo;
        // $adUser->initials = $student->initial; // An error occured since this field is too long
        $adUser->givenName = $student->preferedname;
        $adUser->sn = $student->fullname;
        $adUser->streetAddress = $student->address;
        $adUser->l = $student->city;
        $adUser->st = $student->province;
        $adUser->department = $student->department()->firstOrfail()->name;

        $adUser->setDn($DN_Level);
        $adUser->save();
    }

    /**
     * Delete a student data from AD
     * NOTE: This function should be called inside a try catch block.
     */
    private function deleteStudentAD($user, $student)
    {
        $DN_Level = "CN=".$user->username.", OU=".$student->batch_id.", OU=Undergraduate, OU=Students, OU=".$student->faculty()->firstOrfail()->name.", ".env('LDAP_BASE_DN');

        $userToBeDeleted = User::find($DN_Level);

        if($userToBeDeleted) {
            $userToBeDeleted->delete();
        }
    }

    /***
     * Reject a student
     */
    public function rejectStudent($userId){
        // dd($userId);

        $rejectData = request()->validate([
            'keyerror' => ['required','string', 'max:'.env("USER_REJECT_KEYERROR_MAX")],
            'remarks' => ['max:'.env("USER_REJECT_REMARK_MAX")]
        ], $this->messages);

        $student = Student::where('id', $userId)->firstOrfail();
        $facultyCode = $student->faculty()->firstOrfail()->code;
        $user = $student->user()->firstOrfail();

        if($student->is_rejected == 0 && $student->is_verified == 0) {
            try {
                $student->is_rejected = 1;
                $student->save();
            } catch(\Throwable $th) {
                abort(500, 'Unable to reject at the moment!');
            }
            
            try {
                Mail::to($user->email)->send(new EntryRejectionMail($student->preferedname, $user->username, $rejectData));
            } catch(\Throwable $th) {
                $student->is_rejected = 0;
                $student->save();
            }
            
            // dd($rejectData);
            return redirect()->route('getStudentList', ['facultyCode' => $facultyCode, 'batchId' => $student->batch_id])->with('message', 'Profile rejected Succesfully!!');
        }

        // Abort as a bad request
        abort(400);
    }

    /***
     * edit bio details of a student
     */
    public function editBio($username)
    {
        $data = request()->validate([
            'bio' => ['required', 'string', 'max: 200'],
        ], $this->messages);

        $stu = \App\Models\User::where('username', $username)->firstOrfail()->students()->firstOrfail();

        $stu->bio = $data['bio'];
        $stu->save();

        return redirect()->back();

    }

    /***
     * edit Social Media details of a student
     */
    public function editSocialMedia($username)
    {
        $data = request()->validate([
            'cv' => ['string', 'max: 200', 'nullable'],
            'website' => ['string', 'max: 200', 'nullable'],
            'facebook' => ['string', 'max: 200', 'nullable'],
            'linkedin' => ['string', 'max: 200', 'nullable'],
            'twitter' => ['string', 'max: 200', 'nullable'],
            'instagram' => ['string', 'max: 200', 'nullable'],
            'discord' => ['string', 'max: 200', 'nullable'],
            'medium' => ['string', 'max: 200', 'nullable'],
        ], $this->messages);

        $user = \App\Models\User::where('username', $username)->firstOrfail();
        // dd($data);
        if(Arr::has($data,'cv') && $data['cv'] != null) {
            \App\Models\UserSocialMedia::upsert(['id'=>$user->id, 'media_name'=>'cv' , 'media_link'=>$data['cv']], ['media_link']);
        }
        if(Arr::has($data,'website') && $data['website'] != null) {
            \App\Models\UserSocialMedia::upsert(['id'=>$user->id, 'media_name'=>'website' , 'media_link'=>$data['website']], ['media_link']);
        }
        if(Arr::has($data,'linkedin') && $data['linkedin'] != null) {
            \App\Models\UserSocialMedia::upsert(['id'=>$user->id, 'media_name'=>'linkedin' , 'media_link'=>$data['linkedin']], ['media_link']);
        }
        if(Arr::has($data,'facebook') && $data['facebook'] != null) {
            \App\Models\UserSocialMedia::upsert(['id'=>$user->id, 'media_name'=>'facebook' , 'media_link'=>$data['facebook']], ['media_link']);
        }
        if(Arr::has($data,'instagram') && $data['instagram'] != null) {
            \App\Models\UserSocialMedia::upsert(['id'=>$user->id, 'media_name'=>'instagram' , 'media_link'=>$data['instagram']], ['media_link']);
        }
        if(Arr::has($data,'twitter') && $data['twitter'] != null) {
            \App\Models\UserSocialMedia::upsert(['id'=>$user->id, 'media_name'=>'twitter' , 'media_link'=>$data['twitter']], ['media_link']);
        }
        if(Arr::has($data,'medium') && $data['medium'] != null) {
            \App\Models\UserSocialMedia::upsert(['id'=>$user->id, 'media_name'=>'medium' , 'media_link'=>$data['medium']], ['media_link']);
        }
        if(Arr::has($data,'discord') && $data['discord'] != null) {
            \App\Models\UserSocialMedia::upsert(['id'=>$user->id, 'media_name'=>'discord' , 'media_link'=>$data['discord']], ['media_link']);
        }

        return redirect()->back();

    }

    /**
     * Edit contact details of a student
     */
    public function editContactDetails($username) {
        $data = request()->validate([
            'address' => ['string', 'max:'.env("STUDENTS_ADDRESS_MAX", 200), 'nullable'],
            'city' => ['string', 'max:'.env("STUDENTS_CITY_MAX", 50), 'nullable'],
            'province' => ['string', 'max:'.env("STUDENTS_PROVINCE_MAX", 50), 'nullable'],
            'telephone' => ['string', 'max:'.env("STUDENTS_TELEPHONE_MAX", 12), 'regex:/^[0-9]+$/', 'nullable'],
        ], $this->messages);

        // dd($data);

        // Retrive the respective student from the database
        $student = \App\Models\User::where('username', $username)->firstOrfail()->students()->firstOrfail();

        // Update respective fields if not null
        if($data['address'] != null)
            $student->address = $data['address'];

        if($data['city'] != null)
            $student->city = $data['city'];

        if($data['province'] != null)
            $student->province = $data['province'];

        if($data['telephone'] != null)
            $student->telephone = $data['telephone'];
        
        // Save updated fields
        $student->save();

        // dd($student);

        return redirect()->back();
    }
}
