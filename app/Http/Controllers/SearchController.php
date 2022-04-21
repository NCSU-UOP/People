<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class SearchController extends Controller
{
    //
    public function searchStudents(Request $request)
    {
        $data = request()->validate([
            'q' => 'required', 'string', 'max:255', 'regex:/^[\w-]*$/',
            'type' => 'required', 'int', 'min:1', 'max:2',
            'user' => 'required', 'int', 'min:1', 'max:3',
        ]);  
        $type = $data['type'];
        $query = $data['q'];
        $user = $data['user'];
        //student search
        if($user == '1'){
            if($type == '1'){
                $students = Student::select('id','regNo','fullname')->where('preferedname', 'LIKE', "%{$query}%")->take(10)->where('is_verified',1)->where('students.is_rejected', 0)->orderBy('students.regNo', 'asc')->get();
                return \response()->json($students);
            }
            elseif ($type == '2') {
                $students = Student::select('id','regNo','fullname')->where('regNo', 'LIKE', "%{$query}%")->take(10)->where('is_verified',1)->where('students.is_rejected', 0)->orderBy('students.regNo', 'asc')->get();
                return \response()->json($students);
            }
            else{
                $students = Student::select('id','regNo','fullname')->where('fullname', 'LIKE', "%{$query}%")->take(10)->where('is_verified',1)->where('students.is_rejected', 0)->orderBy('students.regNo', 'asc')->get();
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
