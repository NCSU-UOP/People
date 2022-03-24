<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User; 
use App\Models\Batch; 
use App\Models\Faculty;
use Illuminate\Http\Request;

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
        }

        return view('admin.dashboard');
    }

    public function get_batches()
    {
        $faculty = new faculty();
        $faculties = $faculty::all()->toArray();
        $batch = new Batch();
        $batches = $batch::all()->toArray();
        // dd($faculties);
        return view('admin.dashboard')->with('fac', $faculties)->with('batches', $batches);
    }

    //deleting a entry from a users table
    public function delete(User $user)
    {
        $message = "Error";

        $user = User::find($user->id)->delete();
        if($user) {
            $message = "User deleted sucessfully..";
        }
        return redirect('/dashboard')->with('message', $message);
    }
}
