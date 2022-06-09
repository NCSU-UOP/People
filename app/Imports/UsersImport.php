<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Student;
use App\Models\Faculty;
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
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Cache;



class UsersImport implements OnEachRow, WithHeadingRow, WithProgressBar, SkipsEmptyRows, WithValidation, WithEvents
{
    use Importable;
    use RemembersRowNumber;
    private $faculty_id;
    private $batch_id;
    private $usertype;
    private array $data = [];
    private $excelfile_id;

    public function __construct(int $faculty_id,int $batch_id,int $usertype,array $data,int $excelfile_id)
    {
        $this->faculty_id = $faculty_id;
        $this->batch_id = $batch_id;
        $this->usertype = $usertype;
        $this->data = $data;
        $this->excelfile_id = $excelfile_id;

    }
    
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = array_map('trim', $row->toArray());
        cache()->forever("current_row_", $rowIndex);
        dd(cache()->get("current_row_"));
        // dd(now()->unix());
        // dd(session('hello'));

        //creating a user in user table for each row in excel file
        $Username = str_replace(array('/'), '',$row['enrolment_no']);
        $password = Hash::make($row['nic']);
        
        User::updateOrCreate(['username' => $Username],[
            'username' => $Username, 
            'usertype' => $this->usertype,
            'password' => $password,
            'imported_excel_id' => $this->excelfile_id,
        ]);

        $student = ([
            'regNo' => $row['enrolment_no'],
            'batch_id' => $this->batch_id,
            'faculty_id' => $this->faculty_id,
            'fullname' => $row['full_name'],
        ]);
        if(in_array('address',$this->data))
        {
            $student['address'] = $row['address'];
        }
        if(in_array('initial',$this->data))
        {
            $student['initial'] = $row['name'];
        }
        $student['id'] = User::where('username', $Username)->firstOrFail()->id;
        // dd($student);
        Student::updateOrCreate(['regNo' => $row['enrolment_no']],$student);

        //!TODO add each user to AD
    }

    public function rules(): array
    {
        return [
            'enrolment_no' => [
                'required',
                'string',
                // 'unique:students,regNo', 
                'regex:/^([A-Z]{1,3}\/{1}+\d{2}?(\/{1}+[A-Z]{3})?\/{1}+\d{3})$/',
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

    public function withValidator($validator)
    {
        $validator->stopOnFirstFailure()->after(function ($validator) {
            $enrolment_no_list = Arr::pluck($validator->getData(), 'enrolment_no');
            // dd($enrolment_no_list);
            // $count = 0;
            foreach ($enrolment_no_list as $enrolment_no) {
                $regNoArray = explode('/', $enrolment_no);
                $faccode = Faculty::where('id', $this->faculty_id)->firstOrFail()->code;
                if ($regNoArray[0] != $faccode) {
                    $validator->errors()->add( $this->getRowNumber() , 'Faculty selection is wrong!');
                }
                if ($regNoArray[1] != $this->batch_id){
                    $validator->errors()->add( $this->getRowNumber() , 'Batch selection is wrong!');
                }
                // $count++;
            }
            // dd($count);
        });
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $totalRows = $event->getReader()->getTotalRows();

                if (filled($totalRows)) {
                    cache()->forever("total_rows_{$this->excelfile_id}", array_values($totalRows)[0]);
                    cache()->forever("start_date_{$this->excelfile_id}", now()->unix());
                }
            },
            AfterImport::class => function (AfterImport $event) {
                cache(["end_date_{$this->excelfile_id}" => now()], now()->addMinute());
                cache()->forget("total_rows_{$this->excelfile_id}");
                cache()->forget("start_date_{$this->excelfile_id}");
                cache()->forget("current_row_{$this->excelfile_id}");
            },
        ];
    }
}