<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithProgressBar;



use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Validator;



// class UsersImport implements ToModel, WithHeadingRow, WithProgressBar, SkipsEmptyRows
// {
//     use Importable;
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     public function model(array $row)
//     {
//         // dd($row);
        
//         return new User([
//             'username' => $row['enrolment_no'],
//             'usertype' => $row['usertype'],
//             'password' => $row['nic'],
//         ]);
//     }
// }


class UsersImport implements ToCollection, WithHeadingRow, WithProgressBar, SkipsEmptyRows, WithValidation
{
    use Importable;
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

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            //creating a user in user table for each row in excel file
            User::updateOrCreate([
                'username' => $row['enrolment_no'],
                'usertype' => $row['usertype'],
                'password' => $row['nic'],
            ]);

            $student = ([
                'regNo' => $row['enrolment_no'],
                'initial' => $row['name'],
                'address' => $row['address'],
                'batch_id' => $row['batch_id'],
                'faculty_id' => $row['faculty_id'],
            ]); 
            $student['id'] = User::where('username', $row['enrolment_no'])->firstOrFail()->id;

            Student::updateOrCreate($student);
        }
    }

    public function rules(): array
    {
        return [
            'enrolment_no' => [
                'required',
                'string',
                // 'unique:students,regNo', 
                'regex:/^([A-Z]{1,3}\/{1}+\d{2}?(\/{1}+[A-Z]{3})?\/{1}+\d{3})$/'
            ],
            'address' => [
                'required',
                'string'
            ],
            'nic' => [
                'required',
                'string',
                'regex:/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/'
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'enrolment_no.required' => 'The :attribute field is required.',
            'enrolment_no.string' => 'The :attribute should be a string.',
            'enrolment_no.regex' => 'The :attribute format is invalid.',
            'address.required' => 'The :attribute field is required.',
            'address.string' => 'The :attribute should be a string.',
            'nic.required' => 'The :attribute field is required.',
            'nic.string' => 'The :attribute should be a string.',
            'nic.regex' => 'The :attribute format is invalid.',

        ];
    }
}