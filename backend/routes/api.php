<?php

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\VerificationController;

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
/*Public Routes*/

//Create Admin
Route::post('/user/register',[AuthController::class,'register']);

//Login Admin
Route::post('/user/login',[AuthController::class,'login']);



/* Private Routes*/
Route::group(['middleware'=>['auth:sanctum','verified']],function(){

    // Admin Logout
    Route::post('/user/logout',[AuthController::class,'logout']);
    
    

    Route::get('email/resend/{id}', [VerificationController::class,'resend'])->name('verification.resend');

    // Create instructor
    Route::post('/instructor',[InstructorController::class,'store']);
    // Get all instructor
    Route::get('/instructor',[InstructorController::class,'index']);
    // Get specific instructor
    Route::get('/instructor/{id}',[InstructorController::class,'show']);
    // Update specific instructor
    Route::put('/instructor/{id}',[InstructorController::class,'update']);
    // Delete specific instructor
    Route::delete('/instructor/{id}',[InstructorController::class,'destroy']);

    // Create student
    Route::post('/student',[StudentController::class,'store']);
    // Get all student
    Route::get('/student',[StudentController::class,'index']);
    // Get specific student
    Route::get('/student/{id}',[StudentController::class,'show']);
    // Update specific student
    Route::put('/student/{id}',[StudentController::class,'update']);
    // Delete specific student
    Route::delete('/student/{id}',[StudentController::class,'destroy']);

    // Create section
    Route::post('/section',[SectionController::class,'store']);
    // Get all section
    Route::get('/section',[SectionController::class,'index']);
    // Get specific section
    Route::get('/section/{id}',[SectionController::class,'show']);
    // Update specific section
    Route::put('/section/{id}',[SectionController::class,'update']);
    // Delete specific section
    Route::delete('/section/{id}',[SectionController::class,'destroy']);

    // Create subject
    Route::post('/subject',[SubjectController::class,'store']);
    // Get all subject
    Route::get('/subject',[SubjectController::class,'index']);
    // Get specific subject
    Route::get('/subject/{id}',[SubjectController::class,'show']);
    // Update specific section
    Route::put('/subject/{id}',[SubjectController::class,'update']);
    // Delete specific section
    Route::delete('/subject/{id}',[SubjectController::class,'destroy']);

    // Create school
    Route::post('/school',[SchoolController::class,'store']);
    // Get all school
    Route::get('/school',[SchoolController::class,'index']);
    // Get specific school
    Route::get('/school/{id}',[SchoolController::class,'show']);
    // Update specific section
    Route::put('/school/{id}',[SchoolController::class,'update']);
    // Delete specific section
    Route::delete('/school/{id}',[SchoolController::class,'destroy']);

    // Create school-year
    Route::post('/school-year',[SchoolYearController::class,'store']);
    // Get all school-year
    Route::get('/school-year',[SchoolYearController::class,'index']);
    // Get specific school-year
    Route::get('/school-year/{id}',[SchoolYearController::class,'show']);
    // Update specific section
    Route::put('/school-year/{id}',[SchoolYearController::class,'update']);
    // Delete specific section
    Route::delete('/school-year/{id}',[SchoolYearController::class,'destroy']);

   
});

 // Email Verification
 Route::get('email/verify/{id}', [VerificationController::class,'verify'])->name('verification.verify'); // Make sure to keep this as your route name