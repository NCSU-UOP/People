<?php

namespace App\Http\Controllers;

use App\Mail\FormVerificationMail;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Batch;
use App\Models\Student;
// use Illuminate\Http\Request;
// use Illuminate\Support\Arr;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    protected $messages = [
        'required' => 'The :attribute field is required.',
        'same' => 'The :attribute and :other must match.',
        'size' => 'The :attribute must be exactly :size.',
        'min' => 'The :attribute must be greater than :min characters.',
        'max' => 'The :attribute must be less than :max characters.',
        'between' => 'The :attribute value :input is not between :min - :max.',
        'in' => 'The :attribute must be one of the following types: :values',
        'unique' => 'The :attribute is already in use.',
        'exists' => 'The :attribute is invalid.',
        'regex' => 'The :attribute format is invalid.',
        'email' => 'Invalid email.',
        'string' => 'The :attribute should be a string.',
        'integer' => 'The :attribute field is required.',
    ];

    //form selection method
    public function index()
    {
        return view('form.view');
    }

    //student form selection method
    public function studentForm()
    {
        $provinces = [
            'Central Province',
            'Eastern Province',
            'North Central Province',
            'Northern Province',
            'North Western Province',
            'Sabaragamuwa Province',
            'Southern Province',
            'Uva Province',
            'Western Province'
        ];

        $departments = [];
        $departmentCodesAHS = [];
        $faculties = Faculty::select('id', 'name')->orderBy('name')->get()->toArray();
        $facultyCodes = Faculty::select('code')->orderBy('name')->get()->toArray();

        if(Faculty::where('code', 'AHS')->exists())
            $departmentCodesAHS = Department::select('code')->where('faculty_id', Faculty::where('code', "AHS")->firstOrfail()->id)->get()->toArray();

        $batches = Batch::select('id')->get()->toArray();

        // Get all the departments of each faculty
        foreach ($faculties as $key => $faculty) {
            $departments[$faculty['id']] = Faculty::find($faculty['id'])->departments()->select('id', 'name')->get()->toArray();
        }

        return view('form.student')
            ->with('faculties', $faculties)
            ->with('departments', json_encode($departments))
            ->with('batches', $batches)
            ->with('fcodes', json_encode($facultyCodes))
            ->with('dcodes', json_encode($departmentCodesAHS))
            ->with('provinces', $provinces);
    }

    //Email verification and password setting function
    public function verification($username)
    {        
        $user = User::where('username', $username)->firstOrfail();
        $user->email_verified_at = now();
        $user->save();

        return view('form.verification');
    }

    // //updating the password field 
    // public function updatePassword($username)
    // {
    //     $data = request()->validate([
    //         'password' => ['required', 'string', 'min:'.env("USERS_PASSWORD_MIN"), 'max:'.env("USERS_PASSWORD_MAX"), 'confirmed'],
    //     ], $this->messages);

    //     $data['password'] = Hash::make($data['password']);
    //     User::where('username', $username)->update($data);

    //     return redirect('/');
    // }

    // Academic staff froum selection method. (TO BE DEVELOPED)
    public function academicForm()
    {
        return view('comingsoon.comingsoon');
        // return view('form.staff');
    }

    // Non-Academic staff form selection method. (TO BE DEVELOPED)
    public function nonAcademicForm()
    {
        return view('comingsoon.comingsoon');
        // return view('form.staff');
    }

    // Recieve students' form data
    public function storeStudent()
    {   
        $user = request()->validate([
            'username' => ['required','string', 'min:'.env("USERS_USERNAME_MIN"), 'max:'.env("USERS_USERNAME_MAX"), 'unique:users'],
            'email' => ['required', 'email:rfc,dns', 'unique:users'],
        ], $this->messages);

        $user['usertype'] = env('STUDENT');

        // dd($user);

        // Process the registration number
        if(request()->has(['regNo', 'faculty_id', 'batch_id', 'department_id'])) {
            request()['regNo'] = $this->createRegNo(request()->faculty_id, request()->batch_id, request()->department_id, request()->regNo);
        } else {
            abort(400);
        }

        // dd(request()->regNo);

        $student = request()->validate([
            'preferedname' => ['required','string', 'max:'.env("STUDENTS_PREFEREDNAME_MAX")],
            'fullname' => ['required','string', 'max:'.env("STUDENTS_FULLNAME_MAX")],
            'initial' => ['required','string', 'max:'.env("STUDENTS_INITIAL_MAX")],
            'address' => ['required','string', 'max:'.env("STUDENTS_ADDRESS_MAX")],
            'city' => ['required','string', 'max:'.env("STUDENTS_CITY_MAX")],
            'province' => ['required','string', 'max:'.env("STUDENTS_PROVINCE_MAX")],
            'faculty_id' => ['required','int','exists:faculties,id'],
            'department_id' => ['required','int', 'exists:departments,id'],
            'batch_id' => ['required','int','exists:batches,id'],
            'regNo' => ['required','string','unique:students', 'regex:/^([A-Z]{1,3}\/{1}+\d{2}?(\/{1}+[A-Z]{3})?\/{1}+\d{3})$/'],
            'image' => ['required','image'],
        ], $this->messages);

        
        // Create the student's registration number        
        $facultyCode = Faculty::where('id', $student['faculty_id'])->firstOrFail()->code;

        // Create the user
        User::create($user);

        /**
         * Retrive the created user in case we want to delete him at the end of the process.
         * User will be deleted if system could not send a email
         */
        $createdUser = User::where('username', $user['username'])->firstOrFail();

        // Retrive the foreign key of students table
        $student['id'] = $createdUser->id;
        
        // Automatically activeate the account when user fill the form.
        $student['is_activated'] = true;

        // Create the image directory if not exists
        $paths = $this->createDirectory($facultyCode, 'Student', $student['batch_id'], $student['regNo']);

        // Store the image in the respective directory
        $path = $this->storeImage($paths, $student['regNo'], $student['image']);

        // Change the image path in the user data
        $student['image'] = $path;

        // Create student
        Student::create($student);
        
        // Delete user from the users table if the user is not in the students table
        if(!Student::find($student['id'])->exists()) {
            User::find($student['id'])->delete();
        }

        //Mail sending procedure
        try  {
            Mail::to($user['email'])->send(new FormVerificationMail($user["username"]));
        } catch(\Throwable $th) {
            $createdUser->delete();
            return redirect('/form/student')->with('message', 'Something went wrong. Please try again later!')->with('color', 'danger');
        }
        

        return redirect('/form/student')->with('message', 'Form data entered Succesfully!!')->with('color', 'success');
    }

    /**
     * Process the registration number
     */
    private function createRegNo($faculty_id, $batch_id, $department_id, $number)
    {
        $facultyCode = Faculty::where('id', $faculty_id)->firstOrFail()->code;
        $RegNo = $facultyCode.'/'.$batch_id.'/';

        if($facultyCode == "AHS") {
            $departmentCode = Department::select('code')->where('id', $department_id)->firstOrfail()->code;
            $RegNo = $RegNo.$departmentCode.'/';
        }

        $RegNo = $RegNo.$number;

        return $RegNo;
    }

    /**
     * Create the directory if not exists
     * @return paths
     */
    private function createDirectory($faculty_code, $type, $batch_id, $regNo) 
    {
        /**
         * chmode codes has 3 digits (Owner, Group, World)
         * Permission (4 = read only, 7 = read and write and execute)
         */
        $chmode = 744;
        $tmpPath = "";

        if($type == "Student") {
            $tmpPath = $faculty_code.'/'.$type.'/'.$batch_id.'/';

            // For AHS faculty
            if($faculty_code == "AHS") {
                $deptCode = explode('/', $regNo)[2];
                $tmpPath = $tmpPath.$deptCode.'/';
            }

        } else {
            $tmpPath = $faculty_code.'/'.$type.'/';
        }

        // Define and initialize paths for different directories
        $paths = [
            'image_path' => public_path('uploads/images/'.$tmpPath),
            'thumbnail_path' => public_path('uploads/thumbs/'.$tmpPath)
        ];

        // Create paths
        foreach ($paths as $key => $path) {
            if(!File::isDirectory($path)){
                File::makeDirectory($path, $chmode, true, true);
            }
        }

        return $tmpPath;
    }

    /**
     * Change image name
     * Save image in respective directory
     */
    private function storeImage($path, $regNo, $file) 
    {     
        // Create the image name
        $number = explode('/', $regNo);
        $number = $number[count($number)-1];
        
        $imageName = $number.'.png';

        // Load the image, resize it and then save the profile image
        $image = Image::make($file)->fit(400, 400);
        $image->save(public_path('uploads/images/'.$path).$imageName);

        // Resize the image and save the tumbnail
        $image->resize(150,150);
        $image->save(public_path('uploads/thumbs/'.$path).$imageName);

        return $path.$imageName;
    }

    // Resubmission form data will be displayed for the user
    public function resubmission($username)
    {
        $previousStudentData = User::where('username', $username)->firstOrfail();

        // If the user has resubmitted once or the request has no valid signature, the link will be unauthorized
        if (!request()->hasValidSignature() || !$previousStudentData->students()->firstOrfail()->is_rejected) {
            abort(401);
        }

        $provinces = [
            'Central Province',
            'Eastern Province',
            'North Central Province',
            'Northern Province',
            'North Western Province',
            'Sabaragamuwa Province',
            'Southern Province',
            'Uva Province',
            'Western Province'
        ];

        $departments = [];
        $faculties = Faculty::select('id', 'name')->orderBy('name')->get()->toArray();
        $facultyCodes = Faculty::select('code')->orderBy('name')->get()->toArray();

        if(Faculty::where('code', 'AHS')->exists())
            $departmentCodesAHS = Department::select('code')->where('faculty_id', Faculty::where('code', "AHS")->firstOrfail()->id)->get()->toArray();
        
        $batches = Batch::select('id')->get()->toArray();

        // Get all the departments of each faculty
        foreach ($faculties as $key => $faculty) {
            $departments[$faculty['id']] = Faculty::find($faculty['id'])->departments()->select('id', 'name')->get()->toArray();
        }

        // Retrive user information to auto fill data fields
        $student = $previousStudentData->students()->firstOrfail();
        $student->email = $previousStudentData->email;
        $student->username = $previousStudentData->username;

        // To fill the registration number placeholder
        $regNoArray = explode('/', $student->regNo);
        $student->code = implode("/", explode('/', $student->regNo, -1));
        $student->regNo = end($regNoArray);

        $tempDepartment = Faculty::find($student['faculty_id'])->departments()->select('id', 'name')->get()->toArray();

        return view('form.resubmit')
            ->with('student', $student->toArray())
            ->with('faculties', $faculties)
            ->with('departments', json_encode($departments))
            ->with('tempDeps', $tempDepartment)
            ->with('batches', $batches)
            ->with('fcodes', json_encode($facultyCodes))
            ->with('dcodes', json_encode($departmentCodesAHS))
            ->with('provinces', $provinces);
    }

    // Resubmit the form data
    public function submitResubmission($username)
    {
        $previousStudentData = User::where('username', $username)->firstOrfail()->students();

        $student = request()->validate([
            'preferedname' => ['required','string', 'max:'.env("STUDENTS_PREFEREDNAME_MAX")],
            'fullname' => ['required','string', 'max:'.env("STUDENTS_FULLNAME_MAX")],
            'initial' => ['required','string', 'max:'.env("STUDENTS_INITIAL_MAX")],
            'address' => ['required','string', 'max:'.env("STUDENTS_ADDRESS_MAX")],
            'city' => ['required','string', 'max:'.env("STUDENTS_CITY_MAX")],
            'province' => ['required','string', 'max:'.env("STUDENTS_PROVINCE_MAX")],
            'faculty_id' => ['required','int','exists:faculties,id'],
            'department_id' => ['required','int', 'exists:departments,id'],
            'batch_id' => ['required','int','exists:batches,id'],
            'regNo' => ['required','string'],
            'image' => ['image'],
        ], $this->messages);

        // Process the registration number
        if(request()->has(['regNo', 'faculty_id', 'batch_id', 'department_id'])) {
            $student['regNo'] = $this->createRegNo(request()->faculty_id, request()->batch_id, request()->department_id, request()->regNo);
        } else {
            abort(400);
        }
        
        // Check the resubmitted registratino number is already in use by another student?
        $validator = Validator::make($student, [
            'regNo' => ['unique:students,regNo', 'regex:/^([A-Z]{1,3}\/{1}+\d{2}?(\/{1}+[A-Z]{3})?\/{1}+\d{3})$/'],
        ], $this->messages);

        if ($validator->fails() && !$previousStudentData->where('regNo', $student['regNo'])->exists()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check whether the image is updated
        if(request()->has('image')) {
            // Retrive the faculty code
            $facultyCode = Faculty::where('id', $student['faculty_id'])->firstOrFail()->code;
            
            // Create the image directory if not exists
            $paths = $this->createDirectory($facultyCode, 'Student', $student['batch_id'], $student['regNo']);

            // Store the image in the respective directory
            $path = $this->storeImage($paths, $student['regNo'], $student['image']);

            // Change the image path in the user data
            $student['image'] = $path;
        }

        // To evaluate student's informatino again
        $student['is_rejected'] = 0;

        // Update the entry
        $previousStudentData->update($student);

        return redirect('/')->with('message', 'Form data resubmitted Succesfully!!')->with('color', 'success');
    }

    // first time login form data will be displayed for the user
    public function get_firstlogin_StudentForm($username)
    {
        $Imported_UserData = User::where('username', $username)->firstOrfail();

        $provinces = [
            'Central Province',
            'Eastern Province',
            'North Central Province',
            'Northern Province',
            'North Western Province',
            'Sabaragamuwa Province',
            'Southern Province',
            'Uva Province',
            'Western Province'
        ];

        $departments = [];
        // $faculties = Faculty::select('id', 'name')->orderBy('name')->get()->toArray();
        // $facultyCodes = Faculty::select('code')->orderBy('name')->get()->toArray();

        // Retrive user information to auto fill data fields
        $student = $Imported_UserData->students()->firstOrfail();
        $student->email = $Imported_UserData->email;
        $student->username = $Imported_UserData->username;
        $student->facultyname = Faculty::find($student->faculty_id)->name;

        $departments = Faculty::find($student->faculty_id)->departments()->select('id', 'name')->get()->toArray();
        
        // if(Faculty::where('code', 'AHS')->exists()){
        //     $departmentCodesAHS = Department::select('code')->where('faculty_id', Faculty::where('code', "AHS")->firstOrfail()->id)->get()->toArray();
        // }
        // $batches = Batch::select('id')->get()->toArray();

        // To fill the registration number placeholder
        $regNoArray = explode('/', $student->regNo);
        $student->code = implode("/", explode('/', $student->regNo, -1));
        $student->regNo = end($regNoArray);
        // dd($student);
        // $tempDepartment = Faculty::find($student['faculty_id'])->departments()->select('id', 'name')->get()->toArray();

        return view('form.firstlogin')
            ->with('student', $student->toArray())
            ->with('departments', json_encode($departments))
            ->with('provinces', $provinces);
    }

    // submit the one time form data
    public function store_firstlogin_StudentForm($username)
    {
        // dd($username);
        // $importedStudentData = User::where('username', $username)->firstOrfail()->students();
        $importedStudentData = Student::where('id',User::select('id')->where('username', $username)->firstOrfail()->id)->firstOrfail();
        // dd(Student::where('id',User::select('id')->where('username', $username)->firstOrfail()->id)->firstOrfail());
        $student = request()->validate([
            'preferedname' => ['required','string', 'max:'.env("STUDENTS_PREFEREDNAME_MAX")],
            'fullname' => ['required','string', 'max:'.env("STUDENTS_FULLNAME_MAX")],
            'initial' => ['required','string', 'max:'.env("STUDENTS_INITIAL_MAX")],
            'address' => ['required','string', 'max:'.env("STUDENTS_ADDRESS_MAX")],
            'city' => ['required','string', 'max:'.env("STUDENTS_CITY_MAX")],
            'province' => ['required','string', 'max:'.env("STUDENTS_PROVINCE_MAX")],
            'department_id' => ['required','int', 'exists:departments,id'],
            'image' => ['image'],
            'email' => ['required','email'],
        ], $this->messages);
        // dd($student);
        // Process the registration number
        // if(request()->has(['regNo', 'faculty_id', 'batch_id', 'department_id'])) {
        //     $student['regNo'] = $this->createRegNo(request()->faculty_id, request()->batch_id, request()->department_id, request()->regNo);
        // } else {
        //     abort(400);
        // }
        
        // Check the resubmitted registratino number is already in use by another student?
        // $validator = Validator::make($student, [
        //     'regNo' => ['unique:students,regNo', 'regex:/^([A-Z]{1,3}\/{1}+\d{2}?(\/{1}+[A-Z]{3})?\/{1}+\d{3})$/'],
        // ], $this->messages);

        // if ($validator->fails() && !$previousStudentData->where('regNo', $student['regNo'])->exists()) {
        //     return back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }
        // dd($importedStudentData);
        // Retrive the faculty code
        $facultyCode = Faculty::where('id', $importedStudentData['faculty_id'])->firstOrFail()->code;
        
        // Create the image directory if not exists
        $paths = $this->createDirectory($facultyCode, 'Student', $importedStudentData['batch_id'], $importedStudentData['regNo']);

        // Store the image in the respective directory
        $path = $this->storeImage($paths, $importedStudentData['regNo'], $student['image']);

        // Change the image path in the user data
        $student['image'] = $path;

        // To evaluate student's informatino again
        $student['is_activated'] = 1;
        $student['is_verified'] = 1;

        // Update the entry
        $importedStudentData->update($student);

        return redirect('uop/student/profile/'.$username)->with('message', 'Form data resubmitted Succesfully!!');
    }
}
