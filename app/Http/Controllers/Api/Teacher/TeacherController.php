<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Exam;
use App\Models\Student;
use App\Models\Calendar;
use App\Models\ClassRoutine;
use Illuminate\Http\Response;
use App\Models\TeacherAttendance;
use App\Services\CalendarService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Classs\ClassRoutineResource;

class TeacherController extends Controller
{
    public function getDashboardOverview()
    {
        $total_event = Calendar::count();
        $total_exam = Exam::where('session_id', adminSetting()->default_session_id)->count();
        $total_attendance = TeacherAttendance::where('teacher_id', auth()->user()->staff->id)->count();
        $students = Student::whereSessionId(currentSession())->get();
        $total_student = $students->count();
        $male_student = $students->where('gender', 'male')->count();
        $female_student = $students->where('gender', 'female')->count();
        $male_student_percentage =  $male_student && $total_student ? round(($male_student / $total_student) * 100):1;
        $female_student_percentage =  $male_student && $total_student && $female_student ? 100 - $male_student_percentage:0;

        return response()->json([
            'overview' => [
                'total_event' => $total_event,
                'total_exam' => $total_exam,
                'total_student' => $total_student,
                'total_attendance' => $total_attendance,
            ],
            'students_type' => [
                'male_student' => $male_student,
                'female_student' => $female_student,
                'male_student_percentage' => $male_student_percentage,
                'female_student_percentage' => $female_student_percentage,
            ]
        ], 200);
    }

    public function getRoutine(CalendarService $calendarService)
    {
        $user = auth()->user();
        $teacher = $user->staff;

        $routines = ClassRoutine::with(['subject:id,name,code', 'class_room:id,room_no', 'section:id,name', 'classs:id,name'])
            ->where('session_id', currentSession())
            ->where('teacher_id', $teacher->id)
            ->get();

        $weekDays     = ClassRoutine::WEEK_DAYS;
        $calendarData = $calendarService->generateCalendarData($weekDays,$routines);

        return response()->json([
            'weekDays'     => $weekDays,
            'calendarData' => $calendarData
        ], Response::HTTP_OK);
    }

    public function getAttendanceChartOverview()
    {
        $teacher_attendance = TeacherAttendance::where('teacher_id', auth()->user()->staff->id)->get();
        $total_attendance = $teacher_attendance->count();
        $total_absent = $teacher_attendance->where('status', 0)->count();
        $total_present = $teacher_attendance->where('status', 1)->count();
        $present_percentage =  round(($total_present / $total_attendance) * 100);
        $absent_percentage =  100 - $present_percentage;

        return response()->json([
            'total_attendance' => $total_attendance,
            'total_absent' => $total_absent,
            'total_present' => $total_present,
            'present_percentage' => $present_percentage,
            'absent_percentage' => $absent_percentage
        ]);
    }
}
