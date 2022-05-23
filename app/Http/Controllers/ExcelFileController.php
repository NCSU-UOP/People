<?php

namespace App\Http\Controllers;

use App\Models\ExcelDetails;

use Illuminate\Http\Request;

class ExcelFileController extends Controller
{
    //function to import excel file, $id should be given from the route as a parameter
    public function importExcelFile($id)
    {   
        $excel_details = ExcelDetails::where('id', $id)->first();
        $excel_file_link = $excel_details->excel_file_link;
        $excel_filename = $excel_details->excel_filename;
        $usertype = $excel_details->usertype;
        $admin_id = $excel_details->admin_id;
        $batch_id = $excel_details->batch_id;
        // $department_id = $excel_details->department_id;
        $faculty_id = $excel_details->faculty_id;


        try {
            $import = new UsersImport($faculty_id,$batch_id,$usertype);
            $import->import(public_path('/uploads/excelfiles/'.$excel_filename.'.xlsx'));
            return redirect()->back()->with('success', 'Excel file imported!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            return redirect()->back()->with('Error', 'Excel file import terminated!')->with('failures',$failures);
        }

    }

    //function to delete excel file, $id should be given from the route as a parameter,
    //first go through each row of the excel file and delete if any user find in AD corresponding to the row
    //secondly remove the excel file importations from user table by quering the user table with the excel file id -> this should delete the cascaded entries in the student table too
    //finally remove the excel file from the public folder and corresponding entry is deleted from excel_details table 
    public function removeExcelFile($id)
    {   

    }
}
