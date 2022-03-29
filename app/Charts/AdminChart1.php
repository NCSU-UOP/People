<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Faculty;

class AdminChart1 extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        //chart1
        $students = Student::select('faculty_id')->orderBy('faculty_id', 'asc')->get()->countBy('faculty_id')->values()->toArray();
        $unverifiedStudents = Student::select('faculty_id')->where('is_verified',0)->where('is_rejected',0)->orderBy('faculty_id', 'asc')->get()->countBy('faculty_id')->values()->toArray();
        $verifiedStudents = Student::select('faculty_id')->where('is_verified',1)->where('is_rejected',0)->orderBy('faculty_id', 'asc')->get()->countBy('faculty_id')->values()->toArray();
        $rejectedStudents = Student::select('faculty_id')->where('is_verified',0)->where('is_rejected',1)->orderBy('faculty_id', 'asc')->get()->countBy('faculty_id')->values()->toArray();
        $faculties = Faculty::select('code')->orderBy('id', 'asc')->get()->pluck('code')->toArray();
        
        return Chartisan::build()
            ->labels($faculties)
            ->dataset('Total Entries', $students)
            ->dataset('rejected', $rejectedStudents)
            ->dataset('verified', $verifiedStudents)
            ->dataset('unverified', $unverifiedStudents);
            
            


        // return Chartisan::build()
        //     ->labels(['First', 'Second', 'Third'])
        //     ->dataset('Sample', [1, 2, 3])
        //     ->dataset('Sample 2', [3, 2, 1]);
    }

    // public function handler(Request $request): Chartisan
    // {
    //     return Chartisan::build()
    //         ->labels(['First', 'Second', 'Third'])
    //         ->dataset('Sample', [1, 2, 3])
    //         ->dataset('Sample 2', [3, 2, 1]);
    // }
}