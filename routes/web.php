<?php

use App\Models\User;
use msztorc\LaravelEnv\Env;
use App\Models\ClassRoutine;
use Illuminate\Http\Request;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    $user = User::whereEmail('admin@mail.com')->first();
    return Hash::check('passwordd', $user->password);
    return $user->password;






    $filePath =  base_path("/resources/js/locales");

    return $files = \File::files($filePath);

    // return 123;

    $env = new Env();
    $val = $env->setValue('APP_NAME', 'Schooling - School Management');

    echo $val; // Laravel App



    // return auth()->user()->student->id;
    $session_id = adminSetting()->default_session_id;
    return $student_attendance = StudentAttendance::where('student_id', auth()->user()->student->id)->get();
});

Auth::routes();
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

include(base_path('routes/payment.php'));

// ====================Artisan command======================
Route::middleware('auth:sanctum')->group(function () {
    Route::get('route-clear', function () {
        \Artisan::call('route:clear');
        dd("Route Cleared");
    });
    Route::get('optimize', function () {
        \Artisan::call('optimize');
        dd("Optimized");
    });
    Route::get('view-clear', function () {
        \Artisan::call('view:clear');
        dd("View Cleared");
    });
    Route::get('view-cache', function () {
        \Artisan::call('view:cache');
        dd("View cleared and cached again");
    });
    Route::get('config-cache', function () {
        \Artisan::call('config:cache');
        dd("configuration cleared and cached again");
    });
    Route::get('storage-link', function () {
        $path = public_path()."/storage";
        if (file_exists($path)) {
            unlink($path);
        }
        \Artisan::call('storage:link');
        dd("storage link created");
    });
});

Route::get('/{any?}', function () {
    return view('app');
})->where('any', '[\/\w\.-]*');

// Route::get('/password', function() {
//     return bcrypt('123456789');
// });