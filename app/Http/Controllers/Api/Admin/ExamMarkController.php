<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Student;
use App\Models\ExamMark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExamMarkGetStudentRequest;
use App\Http\Requests\ExamMarkSaveRequest;

class ExamMarkController extends Controller
{
    /**
     * Get Students by session_id, class_id, section_id
     *
     */
    public function getStudents(ExamMarkGetStudentRequest $request)
    {
        $students = Student::with(['classs', 'section', 'user',])
            ->where('session_id', adminSetting()->default_session_id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->get();

        return response($students);
    }

    /**
     * Update Or Insert Student marks
     */
    public function saveMark(ExamMarkSaveRequest $request)
    {
        $session_id = adminSetting()->default_session_id;

        foreach ($request->student_data as $row) {
            $mark = ExamMark::where('session_id', $session_id)
                ->where('exam_id', $row['exam_id'])
                ->where('class_id', $row['class_id'])
                ->where('subject_id', $row['subject_id'])
                ->where('section_id', $row['section_id'])
                ->where('roll_no', $row['roll_no'])
                ->first();

            if ($mark) {
                $mark->update($row);
            } else {
                $row['session_id'] = $session_id;
                ExamMark::create($row);
            }
        }

        return responseSuccess(null, null, 'Exam mark update successfully!');
    }

    public function loadMarks(Request $request)
    {
        $request->validate([
            'roll_numbers'       =>  ['required', 'array'],
            'exam_id'       =>  ['required'],
            'class_id'       =>  ['required'],
            'subject_id'       =>  ['required'],
            'section_id'       =>  ['required'],
        ]);

        $marks = ExamMark::whereIn('roll_no', $request->roll_numbers)
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->where('section_id', $request->section_id)
            ->get();

        return response($marks);
    }
}
