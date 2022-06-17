<?php

namespace App\Http\Controllers;

use App\Models\ExcelDetails;
use App\Models\Faculty;
use App\Models\Batch;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Imports\UsersImport;

class ExcelFileController extends Controller
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
        'mimes' => 'File format is invalid. only xlsx is supported.',
    ];

    //function to import excel file, $id should be given from the route as a parameter
    public function importExcelFile($id)
    {    
        session()->forget('failures');
        session()->forget('success');
        session()->forget('error');
        // session([ 'import' => $id ]);
        // dd(session()->has('import'));
        $excel_details = ExcelDetails::where('id', $id)->first();
        $excel_filename = $excel_details->excel_filename;
        $excel_attributes = json_decode($excel_details->attributes);
        $usertype = $excel_details->usertype;
        $admin_id = $excel_details->admin_id;
        $batch_id = $excel_details->batch_id;
        // $department_id = $excel_details->department_id;
        $faculty_id = $excel_details->faculty_id;
        $attributes = [];

        if ($excel_attributes != null){
            $attributes = $excel_attributes;
        }


        try {
            $import = new UsersImport($faculty_id,$batch_id,$usertype,$attributes,$id);
            $import->import(public_path('/uploads/excelfiles/'.$excel_filename.'.xlsx'));
            $excel_details->is_imported = true;
            $excel_details->save();
            return redirect()->back()->with('success', 'Excel file imported!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            // dd(gettype($failures));
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            // dd($failures);
            session(['failures' => $failures]);
            return redirect()->back()->with('Error', 'Excel file import terminated!');
        }

    }

    //function to delete excel file, $id should be given from the route as a parameter,
    //first go through each row of the excel file and delete if any user find in AD corresponding to the row
    //secondly remove the excel file importations from user table by quering the user table with the excel file id -> this should delete the cascaded entries in the student table too
    //finally remove the excel file from the public folder and corresponding entry is deleted from excel_details table 
    public function removeExcelFile($id)
    {   
        // dd("bulk function implimented!");
        $excel_details = ExcelDetails::where('id', $id)->first();
        $imported_user_list = User::where('imported_excel_id', $id)->get();
        $excel_filename = $excel_details->excel_filename;
        dd(count($imported_user_list));
        if(count($imported_user_list) > 0 && ($excel_details->is_imported)){
            foreach($imported_user_list as $user){
                // delete_from_ad($user);  //!TODO impliment this function (do we need to remove them from AD or just delete them from the database allowing the entries to update when correct excel file imported?)
                $user->delete();
            }
            $excel_details->delete();
            unlink(public_path('/uploads/excelfiles/'.$excel_filename.'.xlsx'));
            return redirect()->back()->with('success', 'Excel file removed, Database and AD cleared!');
        }
        elseif(!($excel_details->is_imported)){
            $excel_details->delete();
            unlink(public_path('/uploads/excelfiles/'.$excel_filename.'.xlsx'));
            return redirect()->back()->with('success', 'Excel file removed!');
        }
    }

    // (Super Admin) add excel file
    public function addExcelFile() 
    {
        $faculty = Faculty::select('id', 'name')->get();
        $batch = Batch::select('id')->get();
        $usertype = [[env('STUDENT'),'Student'], [env('ACADEMIC_STAFF'),'Academic Staff'], [env('NON_ACADEMIC_STAFF'),'Non-Academic Staff']];
        // dd($usertype['1']);
        return view('admin.uploadExcel', compact('faculty','batch','usertype'));
    }

    // upload excel file POST method
    public function uploadExcelFile() 
    {
        $usertypes = [env('STUDENT'),env('ACADEMIC_STAFF'),env('NON_ACADEMIC_STAFF')];
        $Data = request()->validate([
            'usertype' => ['required','integer',Rule::in([env('STUDENT'),env('ACADEMIC_STAFF'),env('NON_ACADEMIC_STAFF')])],
            'faculty_id' => ['required','int','exists:faculties,id'],
            'batch_id' => ['int','exists:batches,id'],
            'excel_file' => ['required', 'file', 'mimes:xlsx', 'max:2048'],
            'excelAttributes' => ['array'],
        ], $this->messages);

        dd($Data);
        //!TODO should implement storing the excel file in public folder and storing the details in the database
        //!important before storing excelattributes list do json_encode
        // dd($adminData);

        // return redirect('/dashboard')->with('message', 'User has been created Succesfully 👍');
    }

    // to get import status
    public function status($id)
    {
        // $id = session('import');
        // dd($id);

        return response([
            'started' => filled(cache("start_date_$id")),
            'finished' => filled(cache("end_date_$id")),
            'current_row' => (int) cache("current_row_$id"),
            'total_rows' => (int) cache("total_rows_$id"),
        ]);
    }
}
