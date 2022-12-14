<?php

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
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user_id}', [UserController::class, 'get']);
    });
    Route::prefix('sizes')->group(function () {
        Route::get('/', [SizeController::class, 'index']);
        //Route::get('/{user_id}', [UserController::class, 'get']);
    });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
