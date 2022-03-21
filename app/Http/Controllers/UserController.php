<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
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
            return view('admin.dashboard', compact('admin_list', 'admin'));
        }

        return view('admin.dashboard', compact('admin'));
    }
}
