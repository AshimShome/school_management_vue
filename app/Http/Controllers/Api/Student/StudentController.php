<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Exam;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Traits\Results;
use App\Models\Calendar;
use App\Models\ExamTerm;
use App\Models\Guardian;
use App\Models\Syllabus;
use App\Models\AdminSetting;
use App\Models\ClassRoutine;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\StudentHomework;
use App\Models\StudentAttendance;
use App\Services\CalendarService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StudentRequest;
use App\Mail\SendLoginCredentialMail;
use App\Http\Resources\Exam\ExamResource;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\Exam\ExamScheduleResource;
use App\Http\Resources\Classs\ClassRoutineResource;
use App\Http\Resources\Student\StudentShortResource;

class StudentController extends Controller
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
            $students = Student::whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            })
                ->with('user')
                ->paginate(10);
        } else {
            $students = Student::with(['user'])->paginate(12);
        }

        return StudentResource::collection($students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        // User info
        $user_data = $request->only('name', 'email', 'password');
        $user_data['role'] = 'student';
        $user_data['password'] = bcrypt($request->password);
//        dd($user_data);
        $user = User::create($user_data);
        $user->assignRole('Student');

        // Student info
        $student_data = $request->only('admission_date', 'class_id', 'section_id', 'roll_no', 'parent_id', 'gender');
        $student_data['parent_id'] = $request->parent_id['id'];
        $student_data['user_id'] = $user->id;
        $student_data['session_id'] = currentSession();
        $student = Student::create($student_data);

        // Mail Send
        checkSetup() ? Mail::to($user->email)->send(new SendLoginCredentialMail($user, $request->password)) : '';

        return responseSuccess('student', $student, 'Student create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return $student->load('user', 'section:id,name', 'classs:id,name', 'guardian.user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        // User info
        $user = $student->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Student info
        $student_data = $request->only('admission_date', 'class_id', 'section_id', 'roll_no', 'parent_id', 'gender');
        $student_data['parent_id'] = $request->parent_id['id'];
        $student_data['session_id'] = currentSession();
        $student = $student->update($student_data);

        // Mail Send
        if ($request->password) {
            checkSetup() ? Mail::to($user->email)->send(new SendLoginCredentialMail($user, $request->password)) : '';
        }

        return responseSuccess('student', $student, 'Student Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->user()->delete();
        $student->delete();

        return responseSuccess('student', null, 'Student delete successfully!');
    }

    public function fetchAllGuardians()
    {
        $search = request()->keyword;
        $guardians = Guardian::select(['id', 'user_id'])->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'LIKE', $search . '%');
        })
            ->with(['user:name,id,image'])
            ->get();

        $data = $guardians->map(function ($guardian) {
            return [
                'id'        =>  $guardian->id,
                'name'      =>  $guardian->user->name,
                'image_url' =>  $guardian->user->image_url
            ];
        });

        return $data;
    }

    public function getClassRoutine(CalendarService $calendarService)
    {
        $user = auth()->user();
        $student = $user->student;

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


    public function getAttendance(Request $request)
    {
        $user = auth()->user();
        // $user = User::where('id', 5)->first();
        $student = $user->student;
        $settings = AdminSetting::first();

        $request->validate([
            'month'         =>   ['required', 'min:1', 'max:12', 'numeric'],
            'year'          =>   ['required', 'numeric']
        ]);

        $student_ids = StudentAttendance::select('student_id')
            ->where('student_id', $student->id)
            ->where('session_id', $settings->default_session_id)
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


    public function getExamRoutines(User $user, Request $request)
    {
        $user = auth()->user();
        // $user = User::where('id', 5)->first();
        $student = $user->student;
        $settings = AdminSetting::first();

        $request->validate([
            'exam_id'           =>  ['required'],
        ]);

        $student = $user->student;

        $routines  = ExamSchedule::with(['subject:name,id', 'room'])
            ->where('session_id', $settings->default_session_id)
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->get();

        return ExamScheduleResource::collection($routines);
    }


    public function getExamResults(Request $request)
    {
        $request->validate([
            'exam_id' => ['required'],
        ]);

        $user = auth()->user();
        $student = $user->student;
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

        // return $students;

        $subjects = Subject::where('class_id', $student->class_id)->get();

        return response()->json([
            'students'       =>  $this->formatStudentsResultData($students, $subjects),
            'subjects' =>  $subjects
        ]);
    }


    public function getExamBySession()
    {
        $exams = Exam::where('session_id', adminSetting()->default_session_id)->get();

        return ExamResource::collection($exams);
    }


    public function getExamByTerm(Request $request)
    {
        $exams = Exam::where('session_id', adminSetting()->default_session_id)->get();

        return ExamResource::collection($exams);
    }


    public function getSubjects()
    {
        $user = auth()->user();
        $student = $user->student;

        return response()->json($student->classs->subjects);
    }

    public function getSyllabusTerms()
    {
        $terms = Syllabus::select('exam_id')
            ->groupBy('exam_id')
            ->with('exam')
            ->where('class_id', auth()->user()->student->class_id)
            ->where('session_id', adminSetting()->default_session_id)
            ->oldest('exam_id')
            ->get();

        return response()->json([
            'terms' => $terms,
            'class_id' => auth()->user()->student->class_id
        ]);
    }

    public function getAttendanceChartOverview()
    {
        $student_attendance = StudentAttendance::where('student_id', auth()->user()->student->id)->get();
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

    public function getDashboardOverview()
    {
        $total_event = Calendar::count();
        $total_exam = Exam::where('session_id', adminSetting()->default_session_id)->count();
        $total_subject = Subject::where('class_id', auth()->user()->student->class_id)->count();
        $total_attendance = StudentAttendance::where('student_id', auth()->user()->student->id)->count();

        return response()->json([
            'total_event' => $total_event,
            'total_exam' => $total_exam,
            'total_subject' => $total_subject,
            'total_attendance' => $total_attendance,
        ]);
    }

    public function getHomeworks(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;
        $date = $request->date;

        $homeworks = StudentHomework::with('teacher.user:id,name', 'subject:id,name')
            ->whereSessionId(currentSession())
            ->whereClassId($student->class_id)
            ->whereSectionId($student->section_id)
            ->whereStartDate($date)
            ->latest('start_date')
            ->get();

        return response()->json($homeworks);
    }

    public function getStudentsByClassSection($class_id, $section_id)
    {
        $students = Student::whereSessionId(currentSession())
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->get();

        return StudentShortResource::collection($students);
    }
}
