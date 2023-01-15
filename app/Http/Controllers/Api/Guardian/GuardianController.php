<?php

namespace App\Http\Controllers\Api\Guardian;

use App\Models\Fee;
use App\Models\Exam;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Traits\Results;
use App\Models\Calendar;
use App\Models\Guardian;
use App\Models\Syllabus;
use App\Models\ClassRoutine;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\StudentHomework;
use App\Models\StudentAttendance;
use App\Services\CalendarService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendLoginCredentialMail;
use App\Http\Requests\GuardianRequest;
use App\Http\Resources\Parent\ParentResource;
use App\Http\Resources\Exam\ExamScheduleResource;
use App\Http\Resources\Parent\ParentFeesResource;
use App\Http\Resources\Parent\ParentStudentResource;
use App\Http\Resources\Parent\ParentStudentDetailsResource;

class GuardianController extends Controller
{
    use Results;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('search') && request()->search != null) {
            $search = request('search');
            $guardians = Guardian::whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            })
                ->with('user')
                ->paginate(10);
        } else {
            $guardians = Guardian::with('user')->paginate(12);
        }

        return ParentResource::collection($guardians);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardianRequest $request)
    {
        // User info
        $user_data = $request->only('name', 'email', 'password');
        $user_data['role'] = 'guardian';
        $user_data['password'] = bcrypt($user_data['password']);
        $user = User::create($user_data);
        $user->assignRole('Guardian');

        // Student info
        $parent_data = $request->only('phone', 'gender');
        $parent_data['user_id'] = $user->id;
        $parent_data['session_id'] = currentSession();
        $guardian = Guardian::create($parent_data);

        // Mail Send
        checkSetup() ? Mail::to($user->email)->send(new SendLoginCredentialMail($user, $request->password)) : '';

        return responseSuccess('guardian', $guardian, 'Parent create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function show(Guardian $guardian)
    {
        return new ParentResource($guardian->load('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function update(GuardianRequest $request, Guardian $guardian)
    {
        // User info
        $user = $guardian->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Parent info
        $parent_data = $request->only('phone', 'gender');
        $guardian->update($parent_data);

        // Mail Send
        if ($request->password) {
            checkSetup() ? Mail::to($user->email)->send(new SendLoginCredentialMail($user, $request->password)) : '';
        }

        return responseSuccess('guardian', $guardian, 'Parent  Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guardian $guardian)
    {
        $guardian->user()->delete();
        $guardian->delete();

        return responseSuccess('guardian', null, 'Parent  Deleted successfully!');
    }

    /**
     * Get Students by Parent
     *
     * @return void
     */
    public function getStudentByGuardian()
    {
        $guardian_id = Guardian::where('user_id', auth()->id())->value('id');
        $students = Student::with('user')
            ->where('parent_id', $guardian_id)
            ->get();

        return ParentStudentResource::collection($students);
    }

    /**
     * Get Students by Parent Details
     *
     * @return void
     */
    public function getStudentByGuardianDetails()
    {
        $guardian_id = Guardian::where('user_id', auth()->id())->value('id');
        $students = Student::with('user', 'classs', 'section')
            ->where('parent_id', $guardian_id)
            ->get();

        return ParentStudentDetailsResource::collection($students);
    }

    /**
     * Get Parent students attendance report
     *
     * @param Request $request
     * @return void
     */
    public function getStudentsAttendance(Request $request)
    {
        $user = User::findOrFail($request->student_id);
        $student = $user->student;

        $request->validate([
            'month' =>   ['required', 'min:1', 'max:12', 'numeric'],
            'year' =>   ['required', 'numeric']
        ]);

        $student_ids = StudentAttendance::select('student_id')
            ->where('student_id', $student->id)
            ->where('session_id', adminSetting()->default_session_id)
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->whereMonth('date', $request->month)
            ->whereYear('date', $request->year)
            ->orderBy('student_id', 'ASC')
            ->groupBy('student_id')
            ->pluck('student_id');

        $students = Student::select(['id', 'user_id', 'parent_id', 'session_id', 'class_id', 'section_id', 'roll_no',])
            ->with(['user', 'attendances' => function ($q) {
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

    public function getStudentClassRoutine($student_id, CalendarService $calendarService)
    {
        $student = Student::where('user_id', $student_id)->firstOrFail();

        $routines = ClassRoutine::with(['subject:id,name,code', 'class_room:id,room_no', 'teacher' => function ($q) {
            $q->select(['user_id', 'id']);
            $q->with('user:name,id');
        }, 'section:id,name', 'classs:id,name'])
            ->where('session_id', currentSession())
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->get();

        $weekDays     = ClassRoutine::WEEK_DAYS;
        $calendarData = $calendarService->generateCalendarData($weekDays, $routines);

        return response()->json([
            'weekDays'     => $weekDays,
            'calendarData' => $calendarData
        ], Response::HTTP_OK);
    }

    public function getStudentSyllabusTerms(Request $request)
    {
        $class_id = Student::where('user_id', $request->student_id)->value('class_id');

        $terms = Syllabus::select('exam_id')
            ->groupBy('exam_id')
            ->with('exam')
            ->where('class_id', $class_id)
            ->where('session_id', adminSetting()->default_session_id)
            ->oldest('exam_id')
            ->get();

        return response()->json([
            'terms' => $terms,
            'class_id' => $class_id
        ]);
    }

    public function getStudentAttendanceReport($student_id)
    {
        $student_attendance = StudentAttendance::where('student_id', $student_id)->get();
        $total_attendance = $student_attendance->count();
        $total_absent = $student_attendance->where('status', 0)->count();
        $total_present = $student_attendance->where('status', 1)->count();
        $present_percentage = $total_present && $total_attendance ? round(($total_present / $total_attendance) * 100) : 1;
        $absent_percentage =  $total_present && $total_attendance && $total_absent ? 100 - $present_percentage : 0;

        return response()->json([
            'total_attendance' => $total_attendance,
            'total_absent' => $total_absent,
            'total_present' => $total_present,
            'present_percentage' => $present_percentage,
            'absent_percentage' => $absent_percentage
        ]);
    }

    public function getStudentSubject($student_id)
    {
        $user = User::findOrFail($student_id);
        $student = $user->student;

        return response()->json($student->classs->subjects);
    }

    public function getDashboardOverview()
    {
        $fee = Fee::whereParentId(auth()->user()->guardian->id)
            ->whereSessionId(currentSession())
            ->get();

        $total_event = Calendar::count();
        $total_exam = Exam::where('session_id', adminSetting()->default_session_id)->count();
        $total_expenses = $fee->where('status', 1)->sum('amount');
        $total_due = $fee->where('status', 0)->sum('amount');

        return response()->json([
            'total_event' => $total_event,
            'total_exam' => $total_exam,
            'total_expenses' => $total_expenses,
            'total_due' => $total_due,
        ]);
    }

    public function getDashboardDueFees($student_id)
    {
        $duefees = Fee::with('student.user', 'type', 'class', 'section')
            ->whereSessionId(currentSession())
            ->whereParentId(auth()->user()->guardian->id)
            ->whereStudentId($student_id)
            ->whereStatus(0)
            ->get();

        return ParentFeesResource::collection($duefees);
    }

    public function getExamResults(Request $request)
    {
        $request->validate([
            'student_id' => ['required'],
            'exam_id' => ['required'],
        ]);

        $student = Student::where('user_id', $request->student_id)->firstOrFail();
        $session_id = adminSetting()->default_session_id;

        $students = Student::with(['user:name,id', 'marks' => function ($q) use ($request, $student, $session_id) {
            $q->select('id', 'subject_id', 'roll_no', 'mark');
            $q->where('session_id', $session_id);
            $q->where('exam_id', $request->exam_id);
            $q->where('class_id', $student->class_id);
            $q->where('section_id', $student->section_id);
            $q->with(['subject:id,name,code']);
        }])
            ->where('roll_no', $student->roll_no)
            ->where('session_id', $session_id)
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->select(['roll_no', 'id', 'user_id', 'class_id', 'section_id'])
            ->get();

        $subjects = Subject::where('class_id', $student->class_id)->get();

        return response()->json([
            'students'       =>  $this->formatStudentsResultData($students, $subjects),
            'subjects' =>  $subjects
        ]);
    }

    public function getExamRoutines(Request $request)
    {
        $request->validate([
            'exam_id' => ['required'],
            'student_id' => ['required'],
        ]);

        $student = Student::where('user_id', $request->student_id)->first();

        $routines  = ExamSchedule::with(['subject:name,id', 'room'])
            ->where('session_id', adminSetting()->default_session_id)
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->oldest('exam_date')
            ->get();

        return ExamScheduleResource::collection($routines);
    }

    public function getFees()
    {
        $fees = Fee::with('student.user', 'type', 'class', 'section')
            ->whereSessionId(currentSession())
            ->whereParentId(auth()->user()->guardian->id)
            ->oldest('status')
            ->get();

        return ParentFeesResource::collection($fees);
    }

    public function getStudentHomeworks(Request $request)
    {
        $request->validate([
            'student_id' => ['required'],
            'date' => ['required'],
        ]);

        $date = $request->date;
        $student = Student::findOrFail($request->student_id);

        $homeworks = StudentHomework::with('teacher.user:id,name', 'subject:id,name')
            ->whereSessionId(currentSession())
            ->whereClassId($student->class_id)
            ->whereSectionId($student->section_id)
            ->whereStartDate($date)
            ->latest('start_date')
            ->get();

        return response()->json($homeworks);
    }
}
