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
        $faculty = new faculty();
        $faculties = $faculty::all()->toArray();
        $batch = new Batch();
        $batches = $batch::all()->toArray();
        // dd($faculties);
        return view('people.student')->with('fac', $faculties)->with('batches', $batches);
    }

    //redirect to profile view route method
    public function getProfile($facultyName,$batch,$id)
    {
        // dd($id);
        $user = new User();
        $username = $user::select('username')->where('id',$id)->first()->toArray();
        // dd($username);
        return redirect('uop/student/profile/'.$username['username']);
    }

    //profile view method
    public function getProfileDetails($username)
    {
        // dd($username);
        $user = new User();
        $user = $user::select('id','email')->where('username',$username)->first()->toArray();
        // dd($userid);
        $student = new Student();
        $studentdata = $student::where('id',$user['id'])->first()->toArray();
        $faculty = new Faculty();
        $department = new Department();
        $facultyName = $faculty::where('id',$studentdata['faculty_id'])->first()->toArray();
        $departmentName = $department::where('id',$studentdata['department_id'])->first()->toArray();
        $date = date('d-m-Y',strtotime($studentdata['updated_at']));

        $studentdata = Arr::add($studentdata,'facultyName',$facultyName['name']);
        $studentdata = Arr::add($studentdata,'departmentName',$departmentName['name']);
        $studentdata = Arr::add($studentdata,'username',$username);
        $studentdata = Arr::add($studentdata,'email',$user['email']);
        $studentdata = Arr::add($studentdata,'date',$date);
        // dd($studentdata);
        return view('people.profile')->with('student',$studentdata);
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
        $studentList = $student::select('id','image', 'fullname', 'regNo')->where('faculty_id', $facultyData['id'])->where('batch_id', $batch)->where('is_verified', 1)->where('is_rejected', 0)->orderBy('regNo', 'asc')->get()->toArray();

        // Change the image url to pick its respective thumbnails
        // foreach ($people as $key => $person) {
        //     $image_link = explode('\\', $person->image);
        //     $image_link[2] = 'thumbs';
        //     $person->image = implode('/', $image_link);
        // }

        // Change the image url to pick its respective thumbnails
        // foreach ($studentList as $key => $student) {
        //     $image_link = explode('\\', $student->image);
        //     $image_link[2] = 'thumbs';
        //     $student->image = implode('/', $image_link);
        // }

        //dd($studentList);
        return view('people.studentList')->with('facultyName', $facultyData['name'])->with('studentlist', $studentList)->with('batch', $batch);
    }
}
