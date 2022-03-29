<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Faculty;
use App\Models\Batch;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
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
            $batch = new Batch();
            $batches = $batch::all()->toArray();

            $count = [];
            foreach($batches as $batch){
                $unverified_count=Student::where([['faculty_id','=',$facultyId],['is_verified','=','0'],['is_rejected','=','0'],['regNo','like',$facultyCode.'%'],['batch_id','=',$batch['id']]])->count();
                $count = Arr::add($count, $batch['id'], $unverified_count);
            }
            return view('admin.dashboard', compact('facultyCode','batches','count'));
        }
        
        return view('admin.dashboard');
    }

    public function get_studList($facultyCode,$batch){
        $studentList = Student::select('id','regNo','initial')->where([['is_verified','=','0'],['regNo','like',$facultyCode.'/%'],['batch_id','=',$batch]])->get();
        $studentList = $studentList->toArray();
        //dd($studentList);        
        return view('admin.unverifiedList')->with('studentList',$studentList);
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
}
