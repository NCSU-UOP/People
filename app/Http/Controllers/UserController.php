<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Faculty;
use App\Models\Batch;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Mail;
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
            return view('admin.dashboard', compact('admin_list'));
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
        $user->name = $user->admins()->first()->name;
        $user->faculty_id = $user->admins()->first()->faculty_id;
        $user->faculty_name = $user->admins()->first()->faculty()->first()->name;

        $user = $user->toJson();
        $faculty = Faculty::all()->toJson();

        return view('admin.edit', compact('user', 'faculty'));
    }

    //updating the user details
    public function update(User $user)
    {
        $data = request()->validate([
            "name" => ['required', 'string', 'max:50'],
            "username" =>['prohibited'],
            "email" =>['prohibited'],
            "faculty_id" =>['required', 'int','exists:faculties,id'],
            "is_admin" => ['required' , 'int'],
            "password" => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $adminUpdate['faculty_id'] = $data['faculty_id'];
        $adminUpdate['is_admin'] = $data['is_admin'];
        $adminUpdate['name'] = $data['name'];

        $userUpdate['password'] = Hash::make($data['password']);

        User::find($user->id)->update($userUpdate);
        Admin::find($user->id)->update($adminUpdate);

        return redirect('/dashboard')->with('message', 'User update sucessfully 👍');
    }

    // (Super Admin) add user
    public function createUser() 
    {
        $faculty = Faculty::select('id', 'name')->get();
        return view('admin.createUser', compact('faculty'));
    }

    // (Super Admin) add faculty
    public function createFaculty() 
    {
        return view('admin.createFaculty');
    }

    // (Super Admin) add batch
    public function createBatch() 
    {
        return view('admin.createBatch');
    }

    // add user POST method
    public function addUser() 
    {
        $userData = request()->validate([
            'username' => ['required','string', 'min:'.env("USERS_USERNAME_MIN"), 'max:'.env("USERS_USERNAME_MAX"), 'unique:users'],
            'email' => ['required', 'email:rfc,dns', 'unique:users'],
            'password' => ['required', 'string', 'min:'.env("USERS_PASSWORD_MIN"), 'max:'.env("USERS_PASSWORD_MAX"), 'confirmed']
        ], $this->messages);

        $adminData = request()->validate([
            'name' => ['required','string', 'max:'.env("USERS_NAME_MAX"), 'min:'.env("USERS_NAME_MIN")],
            'faculty_id' => ['required','int','exists:faculties,id'],
            'is_admin' => ['required', 'boolean'],
            'remark' => ['required', 'string', 'max:'.env("ADMINS_REMARK_MAX")],

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

    public function createDepartment(){
        $admin = User::find(auth()->user()->id)->admins()->firstOrfail();
        $facultyName = $admin->faculty()->firstOrfail()->name;
        return view('admin.addDepartment')->with('facultyName',$facultyName);
    }
    public function addDepartment($facultyName){
        $fac_id = Faculty::where('name', $facultyName)->firstOrFail()->id;
        if($fac_id === 8){
            $data = request()->validate([
                "departmentname" => ['required', 'string', 'max:50'],
                "departmentcode" =>['required','string'],
            ]);
            $code = $data['departmentcode'];
        }else{
            $data = request()->validate([
                "departmentname" => ['required', 'string', 'max:50'],
            ]);
            $code = NULL;
        }
        $deptData = [
            'name' => $data['departmentname'],
            'code' => $code,
            'faculty_id' => $fac_id
        ];
        Department::create($deptData);
        //dd($fac_id);
        return redirect('/dashboard')->with('message', 'Department has been created Succesfully 👍');
    }

}
