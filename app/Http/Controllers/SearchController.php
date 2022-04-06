<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class SearchController extends Controller
{
    //
    public function searchStudents(Request $request)
    {
        if ($request->has('q')) {
        $type = $request->input('type');
        $query = $request->input('q');
        $user = $request->input('user');
            //student search
            if($user == '1'){
                if($type == '1'){
                    $students = Student::select('id','regNo','fullname')->where('fname', 'LIKE', "%{$query}%")->take(10)->where('is_verified',0)->where('students.is_rejected', 0)->orderBy('students.regNo', 'asc')->get();
                    return \response()->json($students);
                }
                elseif ($type == '2') {
                    $students = Student::select('id','regNo','fullname')->where('regNo', 'LIKE', "%{$query}%")->take(10)->where('is_verified',0)->where('students.is_rejected', 0)->orderBy('students.regNo', 'asc')->get();
                    return \response()->json($students);
                }
                else{
                    $students = Student::select('id','regNo','fullname')->where('fullname', 'LIKE', "%{$query}%")->take(10)->where('is_verified',0)->where('students.is_rejected', 0)->orderBy('students.regNo', 'asc')->get();
                    return \response()->json($students);
                }
            }
            //academic staff search
            elseif($user == '2'){
                return \response()->json([]);
            }
            //non-academic staff search
            elseif($user == '3'){
                return \response()->json([]);
            }
        
        }
    }
}
