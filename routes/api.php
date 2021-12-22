<?php

use App\Http\Controllers\MobileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/mobile/signup',[MobileController::class,'signup']);
Route::post('/mobile/login',[MobileController::class,'login']);
Route::get('/mobile/profile',[MobileController::class,'profile']);
Route::post('/mobile/profile_updated',[MobileController::class,'profile_updated']);
Route::post('/mobile/password_reset',[MobileController::class,'pass_reset']);
// Route::post('/mobile/password_forgot',[MobileController::class,'pass_forgot']);
Route::get('/mobile/get_categories',[MobileController::class,'get_cat']);
Route::get('/mobile/get_exercises',[MobileController::class,'get_exe']);
Route::get('/mobile/get_questions',[MobileController::class,'get_que']);
Route::post('/mobile/give_answers',[MobileController::class,'give_ans']);
Route::get('/mobile/reset_student',[MobileController::class,'reset_stu']);
Route::get('/mobile/training',[MobileController::class,'training']);
Route::get('/mobile/specific_question',[MobileController::class,'spec_que']);
