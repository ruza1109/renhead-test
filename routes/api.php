<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StatisticController;
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
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
        Route::patch('/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{user}', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::prefix('/traders')->group(function () {
        Route::get('/', [TraderController::class, 'index'])->name('trader.index');
        Route::post('/', [TraderController::class, 'store'])->name('trader.store');
        Route::get('/{trader}', [TraderController::class, 'show'])->name('trader.show');
        Route::patch('/{trader}', [TraderController::class, 'update'])->name('trader.update');
        Route::delete('/{trader}', [TraderController::class, 'delete'])->name('trader.delete');
    });

    Route::prefix('/professors')->group(function () {
        Route::get('/', [ProfessorController::class, 'index'])->name('professor.index');
        Route::post('/', [ProfessorController::class, 'store'])->name('professor.store');
        Route::get('/{professor}', [ProfessorController::class, 'show'])->name('professor.show');
        Route::patch('/{professor}', [ProfessorController::class, 'update'])->name('professor.update');
        Route::delete('/{professor}', [ProfessorController::class, 'delete'])->name('professor.delete');
    });

    Route::prefix('/jobs')->group(function () {
        Route::get('/', [JobController::class, 'index'])->name('job.index');
        Route::post('/{employeeType}/{employee}', [JobController::class, 'store'])->name('job.store');
        Route::get('/{job}', [JobController::class, 'show'])->name('job.show');
        Route::patch('/{job}', [JobController::class, 'update'])->name('job.update');
        Route::delete('/{job}', [JobController::class, 'delete'])->name('job.delete');
    });

    Route::post('/approvals/{job}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::get('/statistics', [StatisticController::class, 'getStatistics'])->name('statistic.getStatistics');
});
