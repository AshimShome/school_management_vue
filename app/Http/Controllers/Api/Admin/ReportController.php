<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Staff;
use App\Models\Classs;
use App\Models\Student;
use App\Models\Subject;
use App\Traits\Results;
use App\Models\ClassRoutine;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ExamResultRule;
use App\Models\StudentAttendance;
use App\Models\TeacherAttendance;
use App\Services\CalendarService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Staff\StaffResource;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\Exam\ExamScheduleResource;
use App\Http\Resources\Classs\ClassRoutineResource;

class ReportController extends Controller
{
    use Results;
    /**
     * Get students report by session, class, section
     */
    public function getStudentsReport(Request $request)
    {
        $request->validate([
            'class_id' =>  ['required'],
            'section_id' =>  ['required'],
        ]);

        $students = Student::whereSessionId(currentSession())
            ->whereClassId($request->class_id)
            ->whereSectionId($request->section_id)
            ->with(['user', 'guardian.user'])
            ->get();

        return StudentResource::collection($students);
    }

    /**
     * Get students report by session, class, section
     */
    public function getClassReport(Request $request)
    {
        $request->validate([
            'class_id'              =>  ['required'],
        ]);

        $class = Classs::with(['sections', 'subjects',])->withCount('students')->where('id', $request->class_id)->first();

        return $class;
    }

    /**
     * Get Teachers Report
     */
    public function getTeacherReport()
    {
        $teachers = Staff::whereDesignation('teacher')
            ->with(['user', 'department'])
            ->get();

        return StaffResource::collection($teachers);
    }

    public function getStaffReport()
    {
        $teachers = Staff::where('designation', '!=', 'teacher')
            ->with(['user'])
            ->get();

        return StaffResource::collection($teachers);
    }

    public function getStudentsAttendance(Request $request)
    {
        $rules = [
            'type'          =>  ['required', 'in:date,month'],
            'class_id'      =>  ['required'],
            'section_id'    =>  ['required'],
        ];

        $session_id = adminSetting()->default_session_id;

        if ($request->type == 'date') {
            $rules['date']          =  ['required', 'date',];
        } else {
            $rules['month']         =  ['required', 'min:1', 'max:12', 'numeric'];
            $rules['year']          =  ['required', 'numeric'];
        }
        $request->validate($rules);

        if ($request->type == 'date') {
            $attendences = StudentAttendance::with(['student' => function ($q) {
                $q->select(['id', 'user_id', 'roll_no']);
                $q->with('user:id,name');
            }])
                ->where('session_id', $session_id)
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->whereDate('date', $request->date)
                ->get();

            return responseSuccess('attendences', $attendences);
        } else {
            $student_ids = StudentAttendance::select('student_id')
                ->where('session_id', $session_id)
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->whereMonth('date', $request->month)
                ->whereYear('date', $request->year)
                ->orderBy('student_id', 'ASC')
                ->groupBy('student_id')
                ->pluck('student_id');

            $students = Student::with(['user', 'attendances' => function ($q) {
                $q->select('id', 'status', 'date', 'student_id');
            }])->whereIn('id', $student_ids)->get();

            $data = [];
            foreach ($students as $student) {
                $attendences = $student->attendances;
                unset($student->attendances);
                $student->attendances = $attendences->groupBy('date');
                $data[] = $student;
            }
            return responseSuccess('attendences', $data);
        }
    }

    /**
     * Get Teacher Attendance
     */
    public function getTeachersAttendance(Request $request)
    {
        $rules = [
            'type' => ['required', 'in:date,month'],
        ];

        if ($request->type == 'date') {
            $rules['date']          =  ['required', 'date',];
        } else {
            $rules['month']         =  ['required', 'min:1', 'max:12', 'numeric'];
            $rules['year']          =  ['required', 'numeric'];
        }
        $request->validate($rules);

        if ($request->type == 'date') {
            $attendences = TeacherAttendance::with(['teacher' => function ($q) {
                $q->select(['id', 'user_id', 'designation', 'phone', 'department_id']);
                $q->with('user:id,name', 'department:id,name');
            }])->whereDate('date', $request->date)->get();
            return responseSuccess('attendences', $attendences);
        } else {

            $teacher_ids = TeacherAttendance::select('teacher_id')
                ->whereMonth('date', $request->month)
                ->whereYear('date', $request->year)
                ->orderBy('teacher_id', 'ASC')
                ->groupBy('teacher_id')
                ->pluck('teacher_id');


            $teachers = Staff::with(['user', 'attendances' => function ($q) {
                $q->select('id', 'status', 'date', 'teacher_id');
            }])->whereIn('id', $teacher_ids)->get();


            $data = [];
            foreach ($teachers as $teacher) {
                $attendences = $teacher->attendances;
                unset($teacher->attendances);
                $teacher->attendances = $attendences->groupBy('date');
                $data[] = $teacher;
            }
            return responseSuccess('attendences', $data);
        }
    }

    /**
     * Get Exam Routine
     */
    public function getExamRoutines(Request $request)
    {
        $request->validate([
            'exam_id'           =>  ['required'],
            'class_id'          =>  ['required'],
            'section_id'        =>  ['required'],
            'session_id'        =>  ['required'],
        ]);

        $routines  = ExamSchedule::with(['subject:name,id', 'room'])
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('session_id', $request->session_id)
            ->get();

        return ExamScheduleResource::collection($routines);


        // $user = auth()->user();
        // // $user = User::where('id', 5)->first();
        // $student = $user->student;
        // $settings = AdminSetting::first();

        // $request->validate([
        //     'exam_id'           =>  ['required'],
        // ]);

        // $student = $user->student;

        // $routines  = ExamSchedule::with(['subject:name,id', 'room'])
        //     ->where('section_id', $student->section_id)
        //     ->where('exam_id', $request->exam_id)
        //     ->where('class_id', $student->class_id)
        //     ->get();

        // return ExamScheduleResource::collection($routines);
    }

    public function getExamResults(Request $request)
    {
        $request->validate([
            'exam_id'           =>  ['required'],
            'class_id'          =>  ['required'],
            'section_id'        =>  ['required'],
        ]);
        $session_id = adminSetting()->default_session_id;

        $students = Student::with(['user:name,id', 'marks' => function ($q) use ($request, $session_id) {
            $q->select('id', 'subject_id', 'roll_no', 'mark');
            $q->where('session_id',  $session_id);
            $q->where('exam_id', $request->exam_id);
            $q->where('class_id', $request->class_id);
            $q->where('section_id', $request->section_id);
            $q->with(['subject:id,name,code']);
        }])
            ->where('session_id',  $session_id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->select(['roll_no', 'id', 'user_id', 'class_id', 'section_id'])
            ->get();

        $subjects = Subject::where('class_id', $request->class_id)->get();

        return response()->json([
            'students'       =>  $this->formatStudentsResultData($students, $subjects),
            'subjects' =>  $subjects
        ]);
    }

    public function getClassRoutine(Request $request, CalendarService $calendarService)
    {
        $request->validate([
            'session_id'        =>  ['required', 'exists:sessions,id'],
            'class_id'        =>  ['required', 'exists:classses,id'],
            'section_id'        =>  ['required', 'exists:sections,id'],
        ]);

        $routines = ClassRoutine::with(['subject:id,name,code', 'class_room:id,room_no', 'teacher' => function ($q) {
            $q->select(['user_id', 'id']);
            $q->with('user:name,id');
        }, 'section:id,name', 'classs:id,name'])
            ->where('session_id', $request->session_id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->get();

        $weekDays     = ClassRoutine::WEEK_DAYS;
        $calendarData = $calendarService->generateCalendarData($weekDays, $routines);

        return response()->json([
            'weekDays'     => $weekDays,
            'calendarData' => $calendarData
        ], Response::HTTP_OK);
    }
}
