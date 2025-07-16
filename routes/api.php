<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\KRSController;


Route::post('/login', [AuthController::class, 'login_api']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('tes', [KRSController::class, 'tes']);
});
