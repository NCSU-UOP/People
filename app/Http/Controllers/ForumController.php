<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForumController extends Controller
{
    //forum selection method
    public function index()
    {
        return view('forum.view');
    }

    //student forum selection method
    public function studentForum()
    {
        return view('forum.student');
    }

    //academic staff froum selection method
    public function staffForum()
    {
        return view('forum.staff');
    }
}
