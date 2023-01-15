<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Staff\AccountantController;

Route::group(['middleware' => 'auth:sanctum', 'namespace' => 'Accountant', 'prefix' => 'accountant'], function () {
    Route::get('/dashboard/overview', [AccountantController::class, 'getDashboardOverview']);
    Route::get('/dashboard/income-expense', [AccountantController::class, 'getIncomeExpense']);
    Route::get('/dashboard/accounting-overview', [AccountantController::class, 'getAccountOverview']);
});
