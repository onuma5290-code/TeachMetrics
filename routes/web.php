<?php

use App\Http\Controllers\NavigatorPagesController;
use Illuminate\Support\Facades\Route;

Route::get('/register', function () {
    return view('register');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/', function () {
    return view('login');
});
Route::get('/register_student', function () {
    return view('register-student');
});
Route::get('/register_teacher', function () {
    return view('register-teacher');
});

// POST endpoints used by tests and forms
Route::post('/register_student', [\App\Http\Controllers\StudentController::class, 'create']);
Route::post('/register_teacher', [\App\Http\Controllers\TeacherController::class, 'create']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/evaluate/{subject_id}', [\App\Http\Controllers\EvaluateController::class, 'create']);

// Route handling with explicit auth checks inside controllers
Route::get('/dashboard_teacher', [NavigatorPagesController::class, 'dashboard_teacher']);
Route::get('/dashboard_student', [NavigatorPagesController::class, 'dashboard_student']);
Route::get('/evaluate/{subject_id}', [NavigatorPagesController::class, 'evaluate']);


// Route::get('/evaluate', function () {
//     return view('evaluate');
// });
