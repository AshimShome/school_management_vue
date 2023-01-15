<?php

namespace App\Http\Controllers\Api\Student;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\AdminSetting;
use Illuminate\Http\Request;
use App\Models\StudentAttendance;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentAttendanceRequest;
use App\Http\Requests\StudentAttendanceSaveRequest;

class AttendanceController extends Controller
{
    /**
     * Get students by class.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getStudents(StudentAttendanceRequest $request)
    {
        $session_id = currentSession();

        $students = Student::select(['id', 'roll_no', 'user_id', 'parent_id', 'session_id', 'class_id', 'section_id'])
            ->with('user:name,id,email')
            ->where('session_id', $session_id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->get();

        $attendences = $this->getStudentAttendancesByDate($request, $students, $session_id);

        $data = [];
        $last7date_attendace = [];
        foreach ($students as $student) {
            $student->attendances = $this->getAttaendance($student, $attendences);
            $last7date_attendace[] = $this->lastSevenDaysAttendances($student, $session_id);
            $data[] = $student;
        }

        return [
            'students' => $data,
            'lastdays_attendace' => $last7date_attendace,
        ];
    }

    /**
     * Save Teacher Attendance
     */
    public function saveStudentAttendance(StudentAttendanceSaveRequest $request)
    {
        $session_id = adminSetting()->default_session_id;

        foreach ($request->student_data as $row) {
            $row['session_id'] = $session_id;
            $attendance = StudentAttendance::where('student_id', $row['student_id'])
                ->where('session_id', $session_id)
                ->where('class_id', $row['class_id'])
                ->where('section_id', $row['section_id'])
                ->where('date', $row['date'])
                ->first();

            if ($attendance) {
                $attendance->update(['status' => $row['status']]);
            } else {
//                dd($row['student_id']);
                $attn = new StudentAttendance();
                $attn->student_id = $row['student_id'];
                $attn->status = $row['status'];
                $attn->class_id = $row['class_id'];
                $attn->section_id = $row['section_id'];
                $attn->date = $row['date'];
                $attn->session_id = $row['session_id'];
                $attn->save();
//                StudentAttendance::create($row);
            }
        }

        return responseSuccess(null, null, 'Student attendance update successfully!');
    }

    /**
     * Get Students Attendance By date
     */
    public function getStudentAttendancesByDate(Request $request, $students, $session_id)
    {
        $students_id = $students->map(fn ($student) => $student->id);

        return  StudentAttendance::whereIn('student_id', $students_id)
            ->where('session_id', $session_id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('date', $request->date)
            ->get(['student_id', 'session_id', 'class_id', 'section_id', 'date', 'status'])
            ->groupBy('student_id');
    }

    /**
     *
     *Get Single Student Attendance Status
     */
    function getAttaendance($student, $attendences)
    {
        $attendence = [];
        $key = (string) $student->id;
        if (isset($attendences[$key])) {
            $attendence['entry'] = true;
            $attendence['status'] = $attendences[$key][0]['status'] == 1 ? true : false;
            // $attendence['note'] = $attendences[$key][0]['note'];
        } else {
            $attendence['entry'] = false;
            $attendence['status'] = false;
            // $attendence['note'] = '';
        }
        return $attendence;
    }

    /**
     *
     *Get Single Student Attendance Status
     */
    function lastSevenDaysAttendances($student, $session_id)
    {
        return StudentAttendance::where('student_id', $student->id)
            ->where('session_id', $session_id)
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->where('date', '>=', Carbon::now()->subDays(7)->format('Y-m-d'))
            ->take(7)
            ->get(['date', 'status'])
            ->transform(fn ($attendance) => [
                'date' => $attendance->date,
                'status' => $attendance->status,
            ]);
    }
}
