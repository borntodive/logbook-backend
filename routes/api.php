<?php

use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Api\CertificationController;
use App\Http\Controllers\Api\DivingController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\RentController;
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
        Route::get('/dashboard', [UserController::class, 'getDashboard']);

        Route::get('/roles', [UserController::class, 'getRoles']);
        Route::get('/duties', [UserController::class, 'getDuties']);
        Route::get('/staff', [UserController::class, 'getStaff']);
        Route::get('/students', [UserController::class, 'getStudents']);
        Route::get('/{user}/role', [UserController::class, 'getUserRole']);
        Route::get('/{user_id}', [UserController::class, 'get']);
        Route::post('/', [UserController::class, 'store']);
        Route::post('/{user}/avatar', [UserController::class, 'uploadAvatar']);
        Route::post('/{user}/role', [UserController::class, 'updateRole']);
        Route::put('/emergency/{user}', [UserController::class, 'updateEmergency']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
        Route::delete('/{user}/avatar', [UserController::class, 'destroyAvatar']);
    });
    Route::prefix('agenda')->group(
        function () {
            Route::get('/', [AgendaController::class, 'index']);
        }
    );
    Route::prefix('balance')->group(
        function () {
            Route::get('/', [BalanceController::class, 'index']);
        }
    );
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/availables', [CourseController::class, 'getAvailables']);
        Route::get('/user/{user}', [CourseController::class, 'getByUser']);

        Route::get('/{course}', [CourseController::class, 'get']);
        Route::get('/{course}/{student_id}', [CourseController::class, 'getStudent']);
        Route::post('/', [CourseController::class, 'store']);
        Route::post('/duplicate/{course}', [CourseController::class, 'duplicate']);
        Route::post('/{course}/users', [CourseController::class, 'addUser']);

        Route::put('/{course}', [CourseController::class, 'update']);
        Route::put('/{course}/{student_id}/exercise', [CourseController::class, 'updateExercise']);
        Route::put('/{course}/{student_id}', [CourseController::class, 'updateStudent']);

        Route::delete('/{course}/diver/{user_id}', [CourseController::class, 'destroyUser']);
        Route::delete('/{course}', [CourseController::class, 'destroy']);
    });
    Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryController::class, 'index']);
        Route::get('/{equipment}', [InventoryController::class, 'get']);
        Route::post('/add-size/{equipment}', [InventoryController::class, 'addSize']);
        Route::delete('/{code}', [InventoryController::class, 'destroy']);
    });
    Route::prefix('rosters')->group(function () {
        Route::get('/', [RosterController::class, 'index']);
        Route::get('/print/{roster}', [RosterController::class, 'print']);
        Route::get('/print-admin/{roster}', [RosterController::class, 'printAdmin']);
        Route::get('/print-tech/{roster}', [RosterController::class, 'printTech']);
        Route::get('/{roster}', [RosterController::class, 'get']);
        Route::put('/dive/{roster}', [RosterController::class, 'updateDive']);
        Route::put('/{roster}', [RosterController::class, 'update']);
        Route::put('/{roster}/{diver_id}/pay', [RosterController::class, 'updateDiverPayment']);
        Route::put('/{roster}/{diver_id}/unpay', [RosterController::class, 'updateDiverUnPayment']);
        Route::put('/{roster}/{diver_id}', [RosterController::class, 'updateDiver']);
        Route::post('/duplicate-dive/{roster}', [RosterController::class, 'duplicateDive']);
        Route::post('/dive/{roster}', [RosterController::class, 'addDive']);
        Route::post('/', [RosterController::class, 'store']);

        Route::post('/{roster}/user/{user}', [RosterController::class, 'addUser']);
        Route::post('/{roster}/course/{course}', [RosterController::class, 'AddCourse']);
        Route::delete('/dive/{roster}', [RosterController::class, 'destroyDive']);
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
        Route::get('/all', [DivingController::class, 'indexAll']);
        Route::get('/{diving}', [DivingController::class, 'get']);
        Route::post('/', [DivingController::class, 'store']);
        Route::post('/{diving}/logo', [DivingController::class, 'uploadLogo']);

        Route::put('/{diving}', [DivingController::class, 'update']);
        Route::delete('/{diving}', [DivingController::class, 'destroy']);
        Route::delete('/{diving}/logo', [DivingController::class, 'destroyLogo']);
    });
    Route::prefix('rents')->group(function () {
        Route::get('/', [RentController::class, 'index']);
        Route::get('/user/{user}', [RentController::class, 'getByUser']);

        Route::get('/{rent}', [RentController::class, 'get']);
        Route::get('/print-agreement/{rent}', [RentController::class, 'printAgreement']);

        Route::put('/{rent}/add-equipment', [RentController::class, 'addEquipment']);
        Route::put('/{rent}', [RentController::class, 'update']);

        Route::post('/', [RentController::class, 'store']);

        Route::delete('equipment/{code}', [RentController::class, 'destroyEquipment']);
        Route::delete('{rent}', [RentController::class, 'destroy']);
    });
});
