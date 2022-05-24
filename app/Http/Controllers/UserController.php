<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Faculty;
use App\Models\Batch;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use App\Models\ExcelDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\AdminCreationMail;
use App\Mail\EntryRejectionMail;

class UserController extends Controller
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
        'integer' => 'The :attribute field is required.',
        'confirmed' => 'Password and Confirm Password must be match',
    ];

    //
    public function __construct()
    {
        $this->middleware('auth');   
    }

    /**
     * Send specific dashboard to both admin and super admin
     */
    public function index()
    {
        /**
         * Super admin page
         */
        $admin = User::find(auth()->user()->id)->admins()->firstOrfail();

        if($admin->is_admin == 1){
            $admin_list = Admin::all();

            foreach($admin_list as $tmp_admin) {
                $user = $tmp_admin->user()->firstOrfail();
                $faculty = $tmp_admin->faculty()->firstOrfail();

                $tmp_admin->username = $user->username;
                $tmp_admin->email = $user->email;
                $tmp_admin->faculty = $faculty->name;
                $tmp_admin->valid = $tmp_admin->active;
                $tmp_admin->admin = $tmp_admin->is_admin;
                $tmp_admin->online = $tmp_admin->last_online;
            }

            $admin_list = $admin_list->toJson();

            //excel file details list
            $excelfile_list = ExcelDetails::all();

            foreach($excelfile_list as $tmp_excelfile) {
                $user = $tmp_excelfile->user()->firstOrfail();
                $faculty = $tmp_excelfile->faculty()->firstOrfail();

                $tmp_excelfile->username = $user->username;
                $tmp_excelfile->faculty = $faculty->name;
                $tmp_excelfile->imported = $tmp_admin->is_imported;
                if($tmp_excelfile->usertype == env('STUDENT')) {
                    $tmp_excelfile->usertype = "Student";
                } else if($tmp_excelfile->usertype == env('ACADEMIC_STAFF')) {
                    $tmp_excelfile->usertype = "Academic Staff";
                } else if($tmp_excelfile->usertype == env('NON_ACADEMIC_STAFF')) {
                    $tmp_excelfile->usertype = "Non-Academic Staff";
                }
            }

            $excelfile_list = $excelfile_list->toJson();
            return view('admin.dashboard', compact('admin_list','excelfile_list'));
        }

        /**
         * Admin page
         */

        $faculty = $admin->faculty()->firstOrfail();
        $facultyCode = $faculty->code;
        $facultyId = $faculty->id;
        $facultyName = $faculty->name;
        $batches = Batch::select('id')->get();

        $count = [];
        foreach($batches as $batch){
            $unverified_count = $faculty->students()->where([['is_verified','=','0'], ['is_rejected','=','0'], ['batch_id','=', $batch->id]])->count();
            $count = Arr::add($count, $batch->id, $unverified_count);
        }

        return view('admin.dashboard', compact('facultyName','facultyCode','batches','count'));
    }
    
    //deleting a entry from a users table
    public function delete(User $user)
    { 
        $message = "Error ❌";

        $user = User::find($user->id)->delete();
        if($user) {
            $message = "User deleted sucessfully ✔";
        }
        return redirect('/dashboard')->with('message', $message);
    }

    //edit user details in the users, admins tables
    public function edit(User $user)
    {
        //creating user json
        $adminData = $user->admins()->firstOrfail();

        // Map user attributes to an object
        $userData = [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'name' => $adminData->name,
            'isAdmin' => $adminData->is_admin,
            'faculty_id' => $adminData->faculty()->firstOrfail()->id,
        ];

        // Retrive all the faculties
        $faculties = Faculty::select('id', 'name')->get()->toArray();

        return view('admin.edit', compact('userData', 'faculties'));
    }

    //updating the user details
    public function update(User $user)
    {
        $adminUpdate = request()->validate([
            "faculty_id" =>['required', 'int','exists:faculties,id'],
            "is_admin" => ['required' , 'boolean'],
            "name" => ['required', 'string', 'max:'.env("ADMINS_NAME_MAX", 100), 'min:'.env("ADMINS_NAME_MIN", 10)],
        ], $this->messages);

        // If a password was entered, then it will be updated in the database
        if(request()->has('password')) {
            if(request()->password != null) {
                // Validate the password
                $userUpdate = request()->validate([
                    "password" => ['string', 'min:'.env("USERS_PASSWORD_MIN", 8), 'max:'.env("USERS_PASSWORD_MAX", 15), 'confirmed'],
                ], $this->messages);
                
                $userUpdate['password'] = Hash::make($userUpdate['password']);

                // Update the password
                User::find($user->id)->update($userUpdate);
            }
        }

        // Update admin informations
        Admin::find($user->id)->update($adminUpdate);

        return redirect('/dashboard')->with('message', 'User update sucessfully!!');
    }

    // (Super Admin) add user
    public function createUser() 
    {
        $faculty = Faculty::select('id', 'name')->get();
        return view('admin.createUser', compact('faculty'));
    }

    // add user POST method
    public function addUser() 
    {
        $userData = request()->validate([
            'username' => ['required','string', 'min:'.env("USERS_USERNAME_MIN", 4), 'max:'.env("USERS_USERNAME_MAX", 20), 'unique:users'],
            'email' => ['required', 'email:rfc,dns', 'unique:users'],
            'password' => ['required', 'string', 'min:'.env("USERS_PASSWORD_MIN", 8), 'max:'.env("USERS_PASSWORD_MAX", 15), 'confirmed']
        ], $this->messages);

        $adminData = request()->validate([
            'name' => ['required','string', 'max:'.env("ADMINS_NAME_MAX", 100), 'min:'.env("ADMINS_NAME_MIN", 10)],
            'faculty_id' => ['required','int','exists:faculties,id'],
            'is_admin' => ['required', 'boolean'],
            'remark' => ['required', 'string', 'max:'.env("ADMINS_REMARK_MAX", 100)],

        ], $this->messages);

        // dd($userData);
        // dd($adminData);
        
        // create a copy of the userData with only username and password included
        $emailData = [
            'username' => $userData['username'],
            'password' => $userData['password'],
            'name' => $adminData['name']
        ];

        // Hash the password and set the usertype as an ADMIN
        $userData['password'] = Hash::make($userData['password']);
        $userData['usertype'] = env('ADMIN');

        // Create the user
        User::create($userData);

        // Create the respective admin
        $adminData['id'] = User::where('username', $userData['username'])->firstOrFail()->id;
        $adminData['active'] = 1;
        Admin::create($adminData);

        // Send an email to the above created user to inform that he has been selected as an admin
        Mail::to($userData['email'])->send(new AdminCreationMail($emailData));

        return redirect('/dashboard')->with('message', 'User has been created Succesfully 👍');
    }
}
