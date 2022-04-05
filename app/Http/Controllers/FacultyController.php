<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Batch;

use LdapRecord\Models\ActiveDirectory\OrganizationalUnit;
// use LdapRecord\Models\ActiveDirectory\User;

class FacultyController extends Controller
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
    ];

    // (super admin) create faculty page
    public function createFaculty()
    {
        return view('faculty.createFaculty');
    }

    // Add a faculty to the system POST method
    public function addFaculty()
    {
        $facultyData = request()->validate([
            'code' => ['required','string', 'max:'.env("FACULTIES_CODE_MAX"), 'unique:faculties', 'regex:/^[A-Z]+$/'],
            'name' => ['required','string', 'max:'.env("FACULTIES_NAME_MAX"), 'min:'.env("FACULTIES_NAME_MIN"), 'unique:faculties'],
            'remark' => ['required', 'string', 'max:'.env("FACULTIES_REMARK_MAX")],
        ], $this->messages);
        
        try {
            // Create Organizational unit for the new faculty
            $this->createFacultyOU($facultyData['name']);

            // If AD OU creates successfully, then the faculty data will be added to the local database
            Faculty::create($facultyData);

        } catch (\Throwable $th) {
            abort(500, 'Error{$th}');
        }
        
        return redirect('/dashboard/add/faculty')->with('message', 'Faculty has been created Succesfully 👍');
    }

    /**
     * Create new organization unit for a faculty
     */
    private function createFacultyOU($facultyName)
    {
        // Create Faculty organization unit
        $DN_level_1 = "OU=".$facultyName.", ".env('LDAP_BASE_DN');
        if(!OrganizationalUnit::find($DN_level_1)) {
            $ou = new OrganizationalUnit();
            $ou->setDn($DN_level_1);
            $ou->save();
        }

        // Create three main user types
        $usertypes = ["Academic Staff", "Non-Academic Staff", "Students"];
        foreach ($usertypes as $key => $usertype) {
            $DN_level_2 = "OU=".$usertype.", ".$DN_level_1; 
            if(!OrganizationalUnit::find($DN_level_2)) {
                $ou = new OrganizationalUnit();
                $ou->setDn($DN_level_2);
                $ou->save();
            }
        }

        // Create three types of academic staff
        $academicStaff = ["Permanent", "Temporary/Contract", "Visiting"];
        foreach ($academicStaff as $key => $academic) {
            $DN_level_3 = "OU=".$academic.", OU=Academic Staff, ".$DN_level_1;
            if(!OrganizationalUnit::find($DN_level_3)) {
                $ou = new OrganizationalUnit();
                $ou->setDn($DN_level_3);
                $ou->save();
            }
        }

        // Create two types of non-academic staff
        $nonAcademicStaff = ["Permanent", "Temporary/Contract/Trainees"];
        foreach ($nonAcademicStaff as $key => $nonAcademic) {
            $DN_level_3 = "OU=".$nonAcademic.", OU=Non-Academic Staff, ".$DN_level_1; 
            if(!OrganizationalUnit::find($DN_level_3)) {
                $ou = new OrganizationalUnit();
                $ou->setDn($DN_level_3);
                $ou->save();
            }
        }

        // Create two types of students
        $students = ["Postgraduate", "Undergraduate"];
        foreach ($students as $key => $student) {
            $DN_level_3 = "OU=".$student.", OU=Students, ".$DN_level_1; 
            if(!OrganizationalUnit::find($DN_level_3)) {
                $ou = new OrganizationalUnit();
                $ou->setDn($DN_level_3);
                $ou->save();
            }
        }

        // Create all batch of undergraduates
        $batches = Batch::select('id')->get()->toArray();
        foreach ($batches as $key => $batch) {
            $DN_level_4 = "OU=".$batch['id'].", OU=Undergraduate, OU=Students, ".$DN_level_1; 
            if(!OrganizationalUnit::find($DN_level_4)) {
                $ou = new OrganizationalUnit();
                $ou->setDn($DN_level_4);
                $ou->save();
            }
        }
    }
}
