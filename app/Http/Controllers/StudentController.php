<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Student;
use LdapRecord\Models\ActiveDirectory\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\EntryRejectionMail;
use App\Mail\SetPasswordMail;
use Illuminate\Support\Facades\Hash;

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
        return view('password.create', compact('username'));
    }

    //updating the password field 
    public function updatePassword($username)
    {
        $data = request()->validate([
            'password' => ['required', 'string', 'min:'.env("USERS_PASSWORD_MIN"), 'max:'.env("USERS_PASSWORD_MAX"), 'confirmed'],
        ], $this->messages);

        $user = \App\Models\User::where('username', $username)->first();
        // dd($user->username);
        $student = $user->students()->first();

        // dd($student->faculty()->firstOrfail()->name);
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
        $user->update($data);

        return redirect('/');
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

        if($student) {
            $user = $student->user()->firstOrfail();
            
            try {
                // Create new user in the AD
                $this->createStudentAD($user, $student);
    
                // If AD user creates successfully, then the user will be verified in the local database
                $student->is_verified = 1;
                $student->save();

            } catch (\Throwable $th) {
                abort(500, 'Error{$th}');
            }

            //Mail sending procedure
            Mail::to($user['email'])->send(new SetPasswordMail($user->username));
            return redirect()->route('getStudentList', ['facultyCode' => $facultyCode, 'batchId' => $student->batch_id])->with('message', 'Profile verified Succesfully!!');
        }

        // Abort as a bad request
        abort(400);
    }

    /**
     * Put student data into AD
     */
    private function createStudentAD($user, $student)
    {
        $DN_Level = "CN=".$user->username.", OU=".$student->batch_id.", OU=Undergraduate, OU=Students, OU=".$student->faculty()->firstOrfail()->name.", ".env('LDAP_BASE_DN');            

        if(!User::find($DN_Level)) {
            $adUser = new User();

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

        if($student) {
            $student->is_rejected = 1;
            $student->save();

            Mail::to($user->email)->send(new EntryRejectionMail($student->preferedname, $user->username, $rejectData));
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
}
