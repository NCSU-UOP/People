<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\faculty;
use App\Models\Batch;

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
        $faculty = new faculty();
        $faculties = $faculty::all()->toArray();
        $batch = new Batch();
        $batches = $batch::all()->toArray();
        // dd($faculties);
        return view('people.student')->with('fac', $faculties)->with('batches', $batches);
    }

    //profile view method(tempory)
    public function getProfile()
    {
        return view('people.profile');
    }
}
