<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeopleController extends Controller
{
    //people selection method
    public function index()
    {
        return view('people.view');
    }

    //people-student selection method
    public function getStudent()
    {
        return view('people.student');
    }

    //profile view method(tempory)
    public function getProfile()
    {
        return view('people.profile');
    }
}
