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
}
