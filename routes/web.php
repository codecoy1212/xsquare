<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\LoginOutController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard',[DashboardController::class,'index'])->name('dash');
Route::get('/schools',[SchoolController::class,'index'])->name('sch');
Route::get('/students',[StudentController::class,'index'])->name('stu');
Route::get('/categories',[ExerciseController::class,'index'])->name('exe');

Route::get('/categories/specific/{id}',[ExerciseController::class,'specific'])->name('spe');

Route::get('/categories/specific/{id1}/exercise/{id2}/questions',[AnswerController::class,'index'])->name('ans');

Route::post('/schools/add',[SchoolController::class,'add_school']);
Route::get('/schools/show',[SchoolController::class,'show_schools']);
Route::delete('/schools/remove',[SchoolController::class,'del_school']);
Route::get('/schools/show/specific',[SchoolController::class,'show_school']);
Route::put('/schools/update',[SchoolController::class,'update_school']);

Route::post('/categories/add',[CategoryController::class,'add_category']);
Route::get('/categories/show',[CategoryController::class,'show_categories']);
// Route::delete('/categories/remove',[CategoryController::class,'del_category']);
// Route::get('/categories/show/specific',[CategoryController::class,'show_category']);
// Route::put('/categories/update',[CategoryController::class,'update_category']);

Route::post('/categories/specific/{id}/exercises/add',[ExerciseController::class,'add_exercise']);
Route::get('/categories/specific/{id}/exercises/show',[ExerciseController::class,'show_exercises']);
Route::delete('/categories/specific/{id}/exercises/remove',[ExerciseController::class,'del_exercise']);
Route::get('/categories/specific/{id}/exercises/show/specific',[ExerciseController::class,'show_exercise']);
Route::put('/categories/specific/{id}/exercises/update',[ExerciseController::class,'update_exercise']);

Route::post('/categories/specific/{id1}/exercise/{id2}/questions/add',[AnswerController::class,'add_question']);
Route::get('/categories/specific/{id1}/exercise/{id2}/questions/show',[AnswerController::class,'show_questions']);
Route::delete('/categories/specific/{id1}/exercise/{id2}/questions/remove',[AnswerController::class,'del_question']);
Route::get('/categories/specific/{id1}/exercise/{id2}/questions/show/specific',[AnswerController::class,'show_question']);
Route::post('/categories/specific/{id1}/exercise/{id2}/questions/update',[AnswerController::class,'update_question']);
Route::get('/categories/specific/{id1}/exercise/{id2}/questions/show/specific/new',[AnswerController::class,'show_question_det']);

Route::get('/students/show',[StudentController::class,'show_students']);
Route::delete('/students/remove',[StudentController::class,'del_student']);

Route::get('/login',[LoginOutController::class,'index']);
Route::post('/login',[LoginOutController::class,'loggingIn'])->name('log');
Route::get('/logout',[LoginOutController::class,'logged_out'])->name('logo');
