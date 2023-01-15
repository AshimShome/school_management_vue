<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Student\StudentController;

Route::group(['middleware' => 'auth:sanctum', 'namespace' => 'Student', 'prefix' => 'student'], function () {
    Route::get('/dashboard/overview', [StudentController::class, 'getDashboardOverview']);
    Route::get('/get-class-routines', [StudentController::class, 'getClassRoutine']);
    Route::post('/get-attendance', [StudentController::class, 'getAttendance']);

    Route::post('/exam-routines', [StudentController::class, 'getExamRoutines']);
    Route::get('/session-exams', [StudentController::class, 'getExamBySession']);

    Route::post('/exam-by-term', [StudentController::class, 'getExamByTerm']);
    Route::post('/exam-results', [StudentController::class, 'getExamResults']);

    Route::get('/syllabuses-terms', [StudentController::class, 'getSyllabusTerms']);

    Route::get('/attendance-chart', [StudentController::class, 'getAttendanceChartOverview']);

    Route::get('/subjects', [StudentController::class, 'getSubjects']);
    Route::get('/homeworks', [StudentController::class, 'getHomeworks']);
});
