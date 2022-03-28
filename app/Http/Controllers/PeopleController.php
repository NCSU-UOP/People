<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use App\Models\Batch;
use Illuminate\Support\Arr;

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
        $faculties = Faculty::all()->toArray();
        $batches = Batch::all()->toArray();
        // dd($faculties);
        return view('people.student')->with('fac', $faculties)->with('batches', $batches);
    }

    public function getAcademic()
    {
        return redirect('/comingsoon');
    }

    public function getNonAcademic()
    {
        return redirect('/comingsoon');
    }

    public function comingsoon()
    {
        return view('comingsoon.comingsoon');
    }

    //redirect to profile view route method
    public function getProfile($facultyName,$batch,$id)
    {
        // dd($id);
        $username = User::where('id',$id)->first()->username;
        // dd($username);
        return redirect('uop/student/profile/'.$username);
    }

    //profile view method
    public function getProfileDetails($username)
    {
        $studentdata = User::where('username', $username)->first()->students()->first()->makeHidden(['department_id', 'faculty_id', 'is_verified', 'created_at', 'updated_at']);

        $studentdata->facultyName = $studentdata->faculty()->first()->name;
        $studentdata->departmentName = $studentdata->department()->first()->name;
        $studentdata->username = $studentdata->user()->first()->username;
        $studentdata->email = $studentdata->user()->first()->email;
        $studentdata->date = date('d-m-Y',strtotime($studentdata['updated_at']));
        $studentdata->image = '/uploads/images/'.$studentdata->image;
        
        // dd($studentdata->toArray());
        return view('people.profile')->with('student',$studentdata->toArray());
    }

    //getting student list method
    public function getStudentList($facultycode,$batch)
    {
        //dd($fac);
        $facultyData = Faculty::where('code', $facultycode)->firstorFail();
        $studentList = $facultyData->students()->select('students.id','students.image', 'students.fullname', 'students.regNo')->where('students.batch_id', $batch)->where('students.is_verified', 1)->where('students.is_rejected', 0)->orderBy('students.regNo', 'asc')->get();
        // dd($facultyData);

        // Change the image url to pick its respective thumbnails 
        foreach ($studentList as $key => $student) {
            $student->image = '/uploads/thumbs/'.$student->image;
        }

        //dd($studentList);
        return view('people.studentList')->with('facultyName', $facultyData->name)->with('studentlist', $studentList->toArray())->with('batch', $batch);
    }
}