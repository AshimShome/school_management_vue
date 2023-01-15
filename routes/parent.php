<?php

use App\Http\Controllers\Api\Guardian\GuardianController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Student\StudentController;

Route::group(['middleware' => 'auth:sanctum', 'namespace' => 'Student', 'prefix' => 'parent'], function () {
    Route::get('/dashboard/overview', [GuardianController::class, 'getDashboardOverview']);
    Route::get('/dashboard/{student_id}/due-fees', [GuardianController::class, 'getDashboardDueFees']);
    Route::get('/students', [GuardianController::class, 'getStudentByGuardian']);
    Route::get('/students/details', [GuardianController::class, 'getStudentByGuardianDetails']);
    Route::get('/student/{student_id}/attendance', [GuardianController::class, 'getStudentAttendanceReport']);
    Route::get('/student/{student_id}/routine', [GuardianController::class, 'getStudentClassRoutine']);
    Route::get('/student/{student_id}/subjects', [GuardianController::class, 'getStudentSubject']);
    Route::get('/student/exam-routines', [GuardianController::class, 'getExamRoutines']);
    Route::post('/student/attendance', [GuardianController::class, 'getStudentsAttendance']);
    Route::get('/students/homeworks', [GuardianController::class, 'getStudentHomeworks']);
    Route::get('/student/syllabuses-terms', [GuardianController::class, 'getStudentSyllabusTerms']);
    Route::post('/exam-results', [GuardianController::class, 'getExamResults']);
    Route::get('/fees', [GuardianController::class, 'getFees']);
});
