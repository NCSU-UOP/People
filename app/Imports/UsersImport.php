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
    private $faculty_id;
    private $batch_id;
    private $usertype;
    private array $data = [];

    public function __construct(int $faculty_id,int $batch_id,int $usertype,array $data)
    {
        $this->faculty_id = $faculty_id;
        $this->batch_id = $batch_id;
        $this->usertype = $usertype;
        $this->data = $data;
    }
    

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            // dd($this->faculty_id);
            //creating a user in user table for each row in excel file
            User::updateOrCreate(['username' => $row['enrolment_no'],'password' => $row['nic']],[
                'username' => $row['enrolment_no'],
                'usertype' => $this->usertype,
                'password' => $row['nic'],
            ]);

            $student = ([
                'regNo' => $row['enrolment_no'],
                'batch_id' => $this->batch_id,
                'faculty_id' => $this->faculty_id,
            ]);
            if(in_array('address',$this->data))
            {
                $student['address'] = $row['address'];
            }
            if(in_array('initial',$this->data))
            {
                $student['initial'] = $row['name'];
            }
            $student['id'] = User::where('username', $row['enrolment_no'])->firstOrFail()->id;
            dd($student);
            Student::updateOrCreate(['regNo' => $row['enrolment_no']],$student);
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