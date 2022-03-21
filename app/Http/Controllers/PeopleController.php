<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\faculty;
use App\Models\Student;
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

    //getting student list method
    public function getStudentList($facultycode,$batch)
    {
        //dd($fac);
        $faculty = new faculty();
        $facultyData = $faculty::select('id','name')->where('code', $facultycode)->firstorFail()->toArray();
        // dd($facultyData);

        // $person = new verifiedData();
        // $people = $person::select('image', 'fullname', 'regNo', 'username')->where('faculty_id', $fac_id)->where('batch_id', $batch)->orderBy('regNo', 'asc')->get();

        $student = new Student();
        $studentList = $student::select('image', 'fullname', 'regNo')->where('faculty_id', $facultyData['id'])->where('batch_id', $batch)->where('is_verified', 1)->where('is_rejected', 0)->orderBy('regNo', 'asc')->get()->toArray();

        // Change the image url to pick its respective thumbnails
        // foreach ($people as $key => $person) {
        //     $image_link = explode('\\', $person->image);
        //     $image_link[2] = 'thumbs';
        //     $person->image = implode('/', $image_link);
        // }

        // Change the image url to pick its respective thumbnails
        foreach ($studentList as $key => $student) {
            $image_link = explode('\\', $student->image);
            $image_link[2] = 'thumbs';
            $student->image = implode('/', $image_link);
        }

        //dd($studentList);
        return view('people.studentList')->with('facultyName', $facultyData['name'])->with('studentlist', $studentList)->with('batch', $batch)->with('facultyname', $fac_name);
    }
}
