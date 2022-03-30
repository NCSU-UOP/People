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

    public function index()
    {
        $admin_id = auth()->user()->id;
        $admin = User::find($admin_id)->admins()->firstOrfail();

        if($admin->is_admin == 1){
            $admin_list = Admin::all();

            foreach($admin_list as $admin) {
                $admin->username = $admin->user()->first()->username;
                $admin->email = $admin->user()->first()->email;
                $admin->faculty = $admin->faculty()->first()->name;
                $admin->valid = $admin->active;
                $admin->admin = $admin->is_admin;
                $admin->online = $admin->last_online;
            }

            $admin_list = $admin_list->toJson();
            return view('admin.dashboard', compact('admin_list'));

        }elseif($admin->is_admin == 0){
            $facultyCode = Faculty::join('admins', 'faculties.id', '=', 'admins.faculty_id')->where('admins.id', $admin_id)->firstOrFail()->code;
            $facultyId = Admin::where('id','=',$admin_id)->firstOrFail()->faculty_id;
            $facultyName = Faculty::find($facultyId)->name;
            $batch = new Batch();
            $batches = $batch::all()->toArray();

            $count = [];
            foreach($batches as $batch){
                $unverified_count=Student::where([['faculty_id','=',$facultyId],['is_verified','=','0'],['is_rejected','=','0'],['regNo','like',$facultyCode.'%'],['batch_id','=',$batch['id']]])->count();
                $count = Arr::add($count, $batch['id'], $unverified_count);
            }
            return view('admin.dashboard', compact('facultyName','facultyCode','batches','count'));
        }
        
        return view('admin.dashboard');
    }
    
    public function view_student($id){
        $student = Student::where('id','=',$id)->get();
        $student = $student[0]->toArray();
        $image_link = explode('\\', $student['image']);
        $image_link[2] = 'thumbs';
        $student['image'] = implode('/', $image_link); 
        $deptName = Department::where('id','=',$student['department_id'])->firstOrFail()->name;
        $facName = Faculty::where('id','=',$student['faculty_id'])->firstOrFail()->name;
        $facultyCode = Faculty::where('id','=',$student['faculty_id'])->firstOrFail()->code;
        //dd($facultyCode);
        return view('admin.unverifiedStudent', compact('student','deptName','facName','facultyCode'));
    }

    public function get_studList($facultyCode,$batch){
        $studentList = Student::select('id','regNo','initial','image')->where([['is_verified','=','0'],['regNo','like',$facultyCode.'/%'],['batch_id','=',$batch]])->get();
        $facName = Faculty::where('code','=',$facultyCode)->firstOrFail()->name;
        foreach ($studentList as $key => $stdtList) {
            $image_link = explode('\\', $stdtList->image);
            $image_link[2] = 'thumbs';
            $stdtList->image = implode('/', $image_link); 
        }       
        return view('admin.unverifiedList',compact('studentList','batch','facName'));
    }

    public function verify($id){
        $updated = Student::where('id','=',$id)->update(['is_verified'=>'1']);
        return back()->with('message', 'Profile verified Succesfully!!');
    }

    public function reject($id){
        $updated = Student::where('id','=',$id)->update(['is_verified'=>'1']);
        return back()->with('message', 'Profile verified Succesfully!!');
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


}
