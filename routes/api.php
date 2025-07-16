<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\KRSController;

// Route::get('/not-found', [AuthController::class, 'not_found'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('jwt-auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('v1/students/{nim}')->group(function() {
        Route::get('/courses/available', [KRSController::class, 'courses_available']);
        Route::prefix('krs')->group(function() {
            Route::get('/current', [KRSController::class, 'krs_current']);
            Route::get('/status', [KRSController::class, 'krs_status']);
            Route::post('/courses', [KRSController::class, 'krs_courses']);
            Route::delete('/courses/{schedule_id}', [KRSController::class, 'krs_courses_delete']);
        });
    });
});
