<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\Admin\FeeController;
use App\Http\Controllers\Api\Admin\ExamController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\ClassController;
use App\Http\Controllers\Api\Admin\EventController;
use App\Http\Controllers\Api\Staff\StaffController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\Admin\ExpenseController;
use App\Http\Controllers\Api\Admin\SectionController;
use App\Http\Controllers\Api\Admin\SessionController;
use App\Http\Controllers\Api\Admin\SubjectController;
use App\Http\Controllers\Api\Staff\TeacherController;
use App\Http\Controllers\Api\Admin\CalendarController;
use App\Http\Controllers\Api\Admin\ExamMarkController;
use App\Http\Controllers\Api\Admin\ExamTermController;
use App\Http\Controllers\Api\Admin\FeesTypeController;
use App\Http\Controllers\Api\Admin\LanguageController;
use App\Http\Controllers\Api\Admin\SyllabusController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Admin\ClassRoomController;
use App\Http\Controllers\Api\Admin\PromotionController;
use App\Http\Controllers\Api\Student\StudentController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Staff\AccountantController;
use App\Http\Controllers\Api\Staff\DepartmentController;
use App\Http\Controllers\Api\Student\HomeworkController;
use App\Http\Controllers\Api\Admin\ExpenseTypeController;
use App\Http\Controllers\Api\Guardian\GuardianController;
use App\Http\Controllers\Api\Admin\AdminSettingController;
// use App\Http\Controllers\Api\Admin\AnnouncementController;
use App\Http\Controllers\Api\Admin\ClassRoutineController;
use App\Http\Controllers\Api\Admin\ExamScheduleController;
use App\Http\Controllers\Api\Student\AttendanceController;
use App\Http\Controllers\Api\Admin\ExamResultRuleController;
use App\Http\Controllers\Api\Staff\TeacherAttendanceController;

include(base_path('routes/student.php'));
include(base_path('routes/teacher.php'));
include(base_path('routes/parent.php'));
include(base_path('routes/accountant.php'));

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [ResetPasswordController::class, 'resetPassword']);

// Get all languages
Route::get('languages', [LanguageController::class, 'index']);
Route::get('app/default', function () {
    return response()->json([
        'language' => env('APP_DEFAULT_LANGUAGE', 'en'),
    ]);
});

// protected api routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/users/details', [UserController::class, 'details']);
    Route::get('/get-current-session', [SessionController::class, 'getCurrentSession']);

    // admin dashboard
    Route::get('/dashboard/overview', [AdminController::class, 'getDashboardOverview']);
    Route::get('/dashboard/{class_id}/due-fees', [AdminController::class, 'getDashboardDuefees']);
    Route::get('/dashboard/income-expense-chart', [AdminController::class, 'getDashboardIncomeExpenseChart']);


    // admin setting
    Route::get('/setting', [AdminSettingController::class, 'fetchSetting'])->withoutMiddleware('auth:sanctum');
    Route::post('/setting', [AdminSettingController::class, 'updateSetting']);
    Route::get('/setting/system', [AdminSettingController::class, 'getSystemSettings']);
    Route::put('/setting/system', [AdminSettingController::class, 'updateSystemSettings']);
    Route::get('/setting/layout', [AdminSettingController::class, 'getLayoutSettings']);
    Route::put('/setting/layout', [AdminSettingController::class, 'updateLayoutSettings']);
    Route::get('/setting/mail', [AdminSettingController::class, 'getMailSettings']);
    Route::put('/setting/mail', [AdminSettingController::class, 'updateMailSettings']);
    Route::get('/setting/payment', [AdminSettingController::class, 'getPaymentSettings']);
    Route::put('/setting/payment/{provider}', [AdminSettingController::class, 'updatePaymentSettings']);
    Route::post('/setting/send-test-mail', [AdminSettingController::class, 'sendTestMail']);
    Route::get('/setting/routine-time_difference', [AdminSettingController::class, 'getRoutineTimeDifference']);
    Route::get('/setting/check-mail-setting', [AdminSettingController::class, 'checkMailSetting']);

    // language route
    Route::get('languages/{locale}', [LanguageController::class, 'show']);
    Route::post('language', [LanguageController::class, 'store']);
    Route::put('language', [LanguageController::class, 'update']);

    //Academic Session
    Route::get('/sessions/year', [SessionController::class, 'getSessionYear']);
    Route::put('/sessions/year/{session}', [SessionController::class, 'setSessionYear']);
    Route::get('/sessions/{session_id}/classes', [SessionController::class, 'getClasses']);
    Route::apiResource('sessions', SessionController::class);

    // users & profile setting
    Route::get('/users/authuser-details', [UserController::class, 'getAuthUserDetails']);
    Route::post('/user/profile/update', [UserController::class, 'profileUpdate']);
    Route::put('/user/password/update/{user}', [UserController::class, 'passwordUpdate']);
    Route::apiResource('users', UserController::class);

    // roles & permission
    Route::get('/role/wise/permissions', [RoleController::class, 'getRoleWisePermissions']);
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit']);
    Route::get('/roles/list', [RoleController::class, 'rolesList']);
    Route::apiResource('roles', RoleController::class);

    // students
    Route::get('student/guardians', [StudentController::class, 'fetchAllGuardians']);
    Route::resource('students', StudentController::class);

    // sections
    Route::get('allsections', [SectionController::class, 'fetchAllSections']);
    Route::get('classes/{class}/section', [SectionController::class, 'classSection']);
    Route::apiResource('sections', SectionController::class)->except('show');

    // subjects
    Route::get('subjects/allclasses', [SubjectController::class, 'create']);
    Route::get('classes/{class_id}/subjects', [SubjectController::class, 'classSubjects']);
    Route::post('subjects/{subject}/update', [SubjectController::class, 'update']);
    Route::apiResource('subjects', SubjectController::class);

    // classes
    Route::get('classes/{class}/sections', [ClassController::class, 'getSectionsByClass']);
    Route::apiResource('classes', ClassController::class);
    Route::post('classrooms/{classroom}/update', [ClassRoomController::class, 'update']);
    Route::apiResource('classrooms', ClassRoomController::class);

    // departments
    Route::post('departments/{department}/update', [DepartmentController::class, 'update']);
    Route::apiResource('departments', DepartmentController::class);
    // syllabus
    Route::post('syllabuses/download', [SyllabusController::class, 'downloadAttachment']);
    Route::get('syllabuses/classes/{class_id}/terms/{exam_id}/get-syllabus-details', [SyllabusController::class, 'getSyllabusDetails']);
    Route::get('syllabuses/{class_id}/get-class-exams', [SyllabusController::class, 'getTermsByClass']);
    Route::get('syllabuses/{class_id}/classes', [SyllabusController::class, 'getSyllabusesByClass']);
    Route::apiResource('syllabuses', SyllabusController::class);

    //Student, teachers, guardians, accountants
    Route::get('classes/{class_id}/section/{section_id}/students', [StudentController::class, 'getStudentsByClassSection']);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('guardians', GuardianController::class);
    Route::apiResource('staffs', StaffController::class);
    Route::post('accountants/{accountant}', [AccountantController::class, 'update']);
    Route::apiResource('accountants', AccountantController::class);
    Route::post('teachers/{teacher}', [TeacherController::class, 'update']);
    Route::apiResource('teachers', TeacherController::class)->except('update');
    Route::get('get-all-teachers', [TeacherController::class, 'getAllTeacher']);
    Route::get('get-admin/{admin}', [AdminController::class, 'getAdmin']);

    //Exam Schedule
    Route::put('/exam-schedules/{schedule}', [ExamScheduleController::class, 'update']);
    Route::delete('exam-schedules/{schedule}', [ExamScheduleController::class, 'destroy']);
    Route::get('exam-schedule/{schedule}', [ExamScheduleController::class, 'show']);
    Route::post('exam-schedules', [ExamScheduleController::class, 'store']);
    Route::get('exams/{exam}/schedules', [ExamScheduleController::class, 'index']);
    // Route::apiResource('exams.schedules', ExamScheduleController::class);

    //Exam Marks
    Route::post('exam-mark/students', [ExamMarkController::class, 'getStudents']);
    Route::post('exam-mark/save', [ExamMarkController::class, 'saveMark']);
    Route::post('exam-mark/marks', [ExamMarkController::class, 'loadMarks']);
    Route::apiResource('exam-result-rules', ExamResultRuleController::class);

    //Reports
    Route::post('reports/students', [ReportController::class, 'getStudentsReport']);
    Route::post('reports/class', [ReportController::class, 'getClassReport']);
    Route::post('reports/teachers', [ReportController::class, 'getTeacherReport']);
    Route::post('reports/staffs', [ReportController::class, 'getStaffReport']);
    Route::post('reports/students-attendance', [ReportController::class, 'getStudentsAttendance']);
    Route::post('reports/get-class-routines', [ReportController::class, 'getClassRoutine']);
    Route::post('reports/teachers-attendance', [ReportController::class, 'getTeachersAttendance']);
    Route::post('reports/exam-routines', [ReportController::class, 'getExamRoutines']);
    Route::post('reports/exam-results', [ReportController::class, 'getExamResults']);

    // announcement
    // Route::resource('announcements', AnnouncementController::class);

    //Class Routine
    Route::post('get-class-routines', [ClassRoutineController::class, 'getClassRoutine']);
    Route::get('class-routines/{classRoutine}', [ClassRoutineController::class, 'show']);
    Route::post('get-class-routines-preview', [ClassRoutineController::class, 'getClassRoutinePreview']);
    Route::post('save-class-routines', [ClassRoutineController::class, 'store']);
    Route::put('update-class-routines/{classRoutine}', [ClassRoutineController::class, 'update']);
    Route::delete('remove-class-routines/{classRoutine}', [ClassRoutineController::class, 'destroy']);

    // Route::post('reports/exam-results', [ReportController::class, 'getExamResults']);
    Route::post('exams-by-session-and-term', [ExamController::class, 'getExamBySessionAndTerm']);
    Route::post('exams-by-session', [ExamController::class, 'getExamBySession']);

    // calendar
    Route::get('calendars/upcoming-events', [CalendarController::class, 'upcomingEvents']);
    Route::apiResource('calendars', CalendarController::class);

    //Messages
    Route::post('messages/get-messages', [MessageController::class, 'getMessageByUserTypeAndMessageType']);
    Route::get('messages/get-roles', [MessageController::class, 'getRoles']);
    Route::resource('messages', MessageController::class)->only(['store']);
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/markallread', [NotificationController::class, 'markAllRead']);
    Route::put('notifications/mark-toggle/{notification_id}', [NotificationController::class, 'markToggleRead']);
    Route::put('notifications/mark-read/{notification_id}', [NotificationController::class, 'markRead']);
    Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::get('notifications/get-notification/{notification_id}', [NotificationController::class, 'getSingleNotification']);

    // Fees
    Route::put('/fees/{fee}/mark-paid', [FeeController::class, 'feeMarkPaid']);
    Route::put('/fees/{fee}/mark-unpaid', [FeeController::class, 'feeMarkUnpaid']);
    Route::post('/feetypes/{feetype}/update', [FeesTypeController::class, 'update']);
    Route::apiResource('feetypes', FeesTypeController::class)->except(['create', 'edit', 'show']);
    Route::apiResource('fees', FeeController::class)->except(['create', 'edit']);

    // Expense
    Route::post('/expensetypes/{expensetype}/update', [ExpenseTypeController::class, 'update']);
    Route::apiResource('expensetypes', ExpenseTypeController::class)->except(['create', 'edit', 'show']);
    Route::apiResource('expenses', ExpenseController::class)->except(['create', 'edit', 'show']);


    //Student attendance
    Route::post('attendance/get-students', [AttendanceController::class, 'getStudents']);
    Route::post('attendance/check', [AttendanceController::class, 'getAttaendance']);
    Route::put('attendance/student', [AttendanceController::class, 'saveStudentAttendance']);

    //Teacher Attendance
    Route::post('attendance/get-teachers', [TeacherAttendanceController::class, 'getTeachers']);
    Route::post('attendance/teachers', [TeacherAttendanceController::class, 'saveTeacherAttendance']);
    Route::post('attendance/get-teachers-attendance', [TeacherAttendanceController::class, 'getAttaendance']);

    // Exams
    Route::get('exams/list', [ExamController::class, 'getExamsList']);
    Route::get('exams/upcoming-exams', [ExamController::class, 'getUpcomingExams']);
    Route::apiResource('exams', ExamController::class);


    // homeworks
    Route::get('homeworks/teachers', [HomeworkController::class, 'getTeachers']);
    Route::apiResource('homeworks', HomeworkController::class);

    // Promotions
    Route::post('promotions/student-list', [PromotionController::class, 'getPromotionStudents']);
    Route::put('promotions/{student}', [PromotionController::class, 'promoteStudents']);
});

// Route::post('student/{user}/get-class-routines',[StudentController::class, 'getClassRoutine']);
