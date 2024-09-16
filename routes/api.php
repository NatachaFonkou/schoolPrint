<?php

use App\Http\Controllers\SubjectClassroomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ConseilDecisionController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentEvaluationController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->group(function () {

    // Routes pour les classrooms
    Route::resource('classrooms', ClassroomController::class);

    // Routes pour les conseil decisions
    Route::resource('conseil-decisions', ConseilDecisionController::class);

    // Routes pour les evaluations
    Route::resource('evaluations', EvaluationController::class);

    // Routes pour les options
    Route::resource('options', OptionController::class);

    // Routes pour les promotions
    Route::resource('promotions', PromotionController::class);

    // Routes pour les students
    Route::resource('students', StudentController::class);

    // Routes pour les student evaluations
    Route::resource('student-evaluations', StudentEvaluationController::class);

    // Routes pour les subjects
    Route::resource('subjects', SubjectController::class);

    // Routes pour les subject Classroom
    Route::resource('subjects-classroom', SubjectClassroomController::class);

    // Routes pour les teachers
    Route::resource('teachers', TeacherController::class);

   });

