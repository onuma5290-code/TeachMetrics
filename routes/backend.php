<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvaluateController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::prefix('backend')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login/student', [AuthController::class, 'loginStudent']);
        Route::post('/login/teacher', [AuthController::class, 'loginTeacher']);

        Route::post('/logout', [AuthController::class, 'logout']);
    });
    Route::post('/create/student', [StudentController::class, 'create']);
    Route::post('/create/teacher', [TeacherController::class, 'create']);
    Route::post('/create/evaluation', [EvaluateController::class, 'create']);
});
