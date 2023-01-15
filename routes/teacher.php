<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Teacher\TeacherController;

Route::group(['middleware' => 'auth:sanctum', 'namespace' => 'Teacher', 'prefix' => 'teacher'], function () {
    Route::get('/dashboard/overview', [TeacherController::class, 'getDashboardOverview']);
    Route::get('/get-routines', [TeacherController::class, 'getRoutine']);
    Route::get('/attendance-chart', [TeacherController::class, 'getAttendanceChartOverview']);
});
