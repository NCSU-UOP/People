<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
        'confirmed' => 'Password and Confirm Password must be match',
    ];

    // (super admin) create department page
    public function createDepartment() {
        $AHSId = null;
        $faculties = Faculty::select('id', 'name')->get()->toArray();

        if(Faculty::where('code', 'AHS')->exists())
            $AHSId = Faculty::where('code', 'AHS')->firstOrfail()->id;
        
        return view('department.createDepartment', compact('faculties', 'AHSId'));
    }

    // Add a department to the system POST method
    public function addDepartment() {

        // First layer of request validation
        $departmentData = request()->validate([
            'faculty_id' => ['required','int','exists:faculties,id'],
            'name' => [
                'required',
                'string', 
                'max:'.env("DEPARTMENTS_NAME_MAX", 100), 
                'min:'.env("DEPARTMENTS_NAME_MIN", 18), 
                Rule::unique('departments')->where(fn ($query) => $query->where('faculty_id', request()->faculty_id)),
            ],
            'code' => ['nullable', 'string', 'max:'.env("FACULTIES_CODE_MAX"), 'unique:departments,code', 'regex:/^[A-Z]+$/'],
        ], $this->messages);

        // This validation must be places after the request validation.
        if(Faculty::where('code', 'AHS')->exists()) {
            $AHSId = Faculty::where('code', 'AHS')->firstOrfail()->id;
            
            $validator = Validator::make(request()->all(), [
                'code' => ['required'],
            ], $this->messages);

            // The department code is required if and only if the considered faculty is AHS faculty
            if ($validator->fails() && $AHSId == $departmentData['faculty_id']) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        Department::create($departmentData);

        return redirect('/dashboard/add/department')->with('message', 'Department has been created Succesfully!!');
    }
}
