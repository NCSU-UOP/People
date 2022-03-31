<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;

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
            'id' => ['required','int', 'unique:faculties'],
            'code' => ['required','string', 'max:'.env("FACULTIES_CODE_MAX"), 'unique:faculties', 'regex:/^[A-Z]+$/'],
            'name' => ['required','string', 'max:'.env("FACULTIES_NAME_MAX"), 'min:'.env("FACULTIES_NAME_MIN"), 'unique:faculties'],
            'remark' => ['required', 'string', 'max:'.env("FACULTIES_REMARK_MAX")],
        ], $this->messages);

        Faculty::create($facultyData);

        return redirect('/dashboard')->with('message', 'Faculty has been created Succesfully 👍');
    }
}
