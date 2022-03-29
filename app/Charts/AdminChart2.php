<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Batch;

class AdminChart2 extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        //get the faculty code from frontend
        $code = $request->query('facultycode');
        //search through the faculty table to get faculty id
        $facultyid = Faculty::select('id')->where('code',$code)->first();

        $batches = Batch::select('id')->whereDate('expire_date','>=', now())->orderBy('id', 'asc')->take(5)->get()->pluck('id')->toArray();

        //queries to get data from student table
        $students = Student::select('batch_id')->where('faculty_id',$facultyid['id'])->whereIn('batch_id',$batches)->orderBy('batch_id', 'asc')->get()->countBy('batch_id')->values()->toArray();
        $unverifiedStudents = Student::select('batch_id')->where('faculty_id',$facultyid['id'])->whereIn('batch_id',$batches)->where('is_verified',0)->where('is_rejected',0)->orderBy('batch_id', 'asc')->get()->countBy('batch_id')->values()->toArray();
        $verifiedStudents = Student::select('batch_id')->where('faculty_id',$facultyid['id'])->whereIn('batch_id',$batches)->where('is_verified',1)->where('is_rejected',0)->orderBy('batch_id', 'asc')->get()->countBy('batch_id')->values()->toArray();
        $rejectedStudents = Student::select('batch_id')->where('faculty_id',$facultyid['id'])->whereIn('batch_id',$batches)->where('is_verified',0)->where('is_rejected',1)->orderBy('batch_id', 'asc')->get()->countBy('batch_id')->values()->toArray();
        // $batches = Batch::select('id')->orderBy('id', 'asc')->get()->pluck('id')->toArray();
        
        return Chartisan::build()
            ->labels($batches)
            ->dataset('Total Entries', $students)
            ->dataset('rejected', $rejectedStudents)
            ->dataset('verified', $verifiedStudents)
            ->dataset('unverified', $unverifiedStudents);

        // return Chartisan::build()
        //     ->labels(['First', 'Second', 'Third'])
        //     ->dataset('Sample', [1, 2, 3])
        //     ->dataset('Sample 2', [3, 2, 1]);
    }
}