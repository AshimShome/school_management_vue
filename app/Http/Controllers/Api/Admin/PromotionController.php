<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function getPromotionStudents(Request $request)
    {
        $students =  Student::with('user:id,name,image','section:id,name','classs:id,name')
            ->whereSessionId($request->session_from)
            ->whereClassId($request->class_from)
            ->get()
            ->groupBy('section.name');

        return response()->json($students);
    }

    public function promoteStudents(Request $request,Student $student){
        $student->update([
            'session_id' => $request->session_to,
            'class_id' => $request->class_to,
        ]);

        return responseSuccess(null, null,'Student Promotion Successfully!');
    }
}
