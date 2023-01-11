<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CertificationController;
use App\Http\Controllers\Api\DivingController;
use App\Http\Controllers\Api\RosterController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\UserController;
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

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/availables', [UserController::class, 'getAvailables']);

        Route::get('/roles', [UserController::class, 'getRoles']);
        Route::get('/duties', [UserController::class, 'getDuties']);
        Route::get('/staff', [UserController::class, 'getStaff']);
        Route::get('/students', [UserController::class, 'getStudents']);
        Route::get('/{user}/role', [UserController::class, 'getUserRole']);
        Route::get('/{user_id}', [UserController::class, 'get']);
        Route::post('/', [UserController::class, 'store']);
        Route::post('/{user}/role', [UserController::class, 'updateRole']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/availables', [CourseController::class, 'getAvailables']);
        Route::get('/user/{user}', [CourseController::class, 'getByUser']);

        Route::get('/{course}', [CourseController::class, 'get']);
        Route::get('/{course}/{student_id}', [CourseController::class, 'getStudent']);
        Route::post('/', [CourseController::class, 'store']);
        Route::post('/duplicate/{course}', [CourseController::class, 'duplicate']);

        Route::put('/{course}', [CourseController::class, 'update']);
        Route::put('/{course}/{student_id}/exercise', [CourseController::class, 'updateExercise']);
        Route::put('/{course}/{student_id}', [CourseController::class, 'updateStudent']);
        Route::delete('/{course}', [CourseController::class, 'destroy']);
    });
    Route::prefix('rosters')->group(function () {
        Route::get('/', [RosterController::class, 'index']);
        Route::get('/{roster}', [RosterController::class, 'get']);
        Route::put('/{roster}', [RosterController::class, 'update']);
        Route::put('/{roster}/{diver_id}', [RosterController::class, 'updateDiver']);
        Route::post('/', [RosterController::class, 'store']);

        Route::post('/{roster}/user/{user}', [RosterController::class, 'addUser']);
        Route::post('/{roster}/course/{course}', [RosterController::class, 'AddCourse']);
        Route::delete('/{roster}/course/{course_id}', [RosterController::class, 'destroyCourse']);
        Route::delete('/{roster}/diver/{user_id}', [RosterController::class, 'destroyUser']);
        Route::delete('/{roster}', [RosterController::class, 'destroy']);
    });
    Route::prefix('certifications')->group(function () {
        Route::get('/all', [CertificationController::class, 'indexAll']);

        Route::get('/{certification}', [CertificationController::class, 'get']);
    });
    Route::prefix('sizes')->group(function () {
        Route::get('/', [SizeController::class, 'index']);
        //Route::get('/{user_id}', [UserController::class, 'get']);
    });
    Route::prefix('equipments')->group(function () {
        Route::get('/', [EquipmentController::class, 'index']);
        //Route::get('/{user_id}', [UserController::class, 'get']);
    });
    Route::prefix('divings')->group(function () {
        Route::get('/', [DivingController::class, 'index']);
        //Route::get('/{user_id}', [UserController::class, 'get']);
    });
});
