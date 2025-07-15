<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return redirect('/login');
});

//login
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

//register
Route::get('/register', [AuthController::class, 'show_register']);
Route::post('/register', [AuthController::class, 'register'])->name('register');

//logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/chart', [HomeController::class, 'chart']);
    Route::get('/test', [HomeController::class, 'test']);

    //profile
    Route::prefix('profile')->group(function() {
        Route::get('/', [ProfileController::class, 'index']);
        Route::get('/delete/{id}', [ProfileController::class, 'destroy']);
    });
    Route::resource("profile", ProfileController::class);

    //module
    Route::prefix('module')->group(function() {
        Route::get('/', [ModuleController::class, 'index']);
        Route::post('/sort', [ModuleController::class, 'sort']);
        Route::get('/delete/{id}', [ModuleController::class, 'destroy']);
    });
    Route::resource("module", ModuleController::class);

    //permission
    Route::prefix('permission')->group(function() {
        Route::get('/', [PermissionController::class, 'index']);
        Route::get('/json', [PermissionController::class, 'json']);
        Route::get('/delete/{id}', [PermissionController::class, 'destroy']);
    });
    Route::resource("permission", PermissionController::class);

    //users
    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/json', [UserController::class, 'json']);
        Route::get('/change-status/{id}', [UserController::class, 'change_status']);
        Route::get('/reset-password/{id}', [UserController::class, 'reset_password'])->name('user.password');
        Route::get('/delete/{id}', [UserController::class, 'destroy']);
    });
    Route::resource("users", UserController::class);

    //option
    Route::prefix('setting-website')->group(function() {
        Route::get('/', [OptionController::class, 'index']);
        Route::get('/delete/{id}', [OptionController::class, 'destroy']);
    });
    Route::resource("setting-website", OptionController::class);


    //category
    Route::prefix('category')->group(function() {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/json', [CategoryController::class, 'json']);
        Route::get('/delete/{id}', [CategoryController::class, 'destroy']);
    });
    Route::resource("category", CategoryController::class);

});

// Route::get('/', function () {
//     return view('welcome');
// });
