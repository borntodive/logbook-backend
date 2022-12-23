<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CertificationController;
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
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/staff', [UserController::class, 'getStaff']);
        Route::get('/students', [UserController::class, 'getStudents']);
        Route::get('/{user_id}', [UserController::class, 'get']);
        Route::get('courses/{user}', [CourseController::class, 'getByUser']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{user}', [UserController::class, 'update']);
    });
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/{course}', [CourseController::class, 'get']);
        Route::get('/{course}/{student_id}', [CourseController::class, 'getStudent']);
        Route::post('/', [CourseController::class, 'store']);
    });
    Route::prefix('certifications')->group(function () {
        Route::get('/all', [CertificationController::class, 'indexAll']);
    });
    Route::prefix('sizes')->group(function () {
        Route::get('/', [SizeController::class, 'index']);
        //Route::get('/{user_id}', [UserController::class, 'get']);
    });
    Route::prefix('equipments')->group(function () {
        Route::get('/', [EquipmentController::class, 'index']);
        //Route::get('/{user_id}', [UserController::class, 'get']);
    });
});
