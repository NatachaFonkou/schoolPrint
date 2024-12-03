<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', \App\Http\Controllers\UserController::class);
Route::apiResource('departments', \App\Http\Controllers\DepartmentController::class);
Route::apiResource('users', \App\Http\Controllers\UserController::class);
Route::apiResource('admins', \App\Http\Controllers\AdminController::class);
Route::apiResource('students', \App\Http\Controllers\StudentController::class);
Route::apiResource('teachers', \App\Http\Controllers\TeacherController::class);
Route::apiResource('courses', \App\Http\Controllers\CourseController::class);
Route::apiResource('results', \App\Http\Controllers\ResultController::class);
Route::apiResource('programs', \App\Http\Controllers\ProgramController::class);
Route::apiResource('group-leaders', \App\Http\Controllers\GroupLeaderController::class);
Route::apiResource('cycles', \App\Http\Controllers\CycleController::class);


