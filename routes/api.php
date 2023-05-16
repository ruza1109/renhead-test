<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TraderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'delete']);
    });

    Route::prefix('/traders')->group(function () {
        Route::get('/', [TraderController::class, 'index']);
        Route::post('/', [TraderController::class, 'store']);
        Route::get('/{trader}', [TraderController::class, 'show']);
        Route::patch('/{trader}', [TraderController::class, 'update']);
        Route::delete('/{trader}', [TraderController::class, 'delete']);
    });
});
