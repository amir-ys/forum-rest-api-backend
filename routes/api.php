<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V01\Auth\AuthController;

route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/user', [AuthController::class, 'user'])->name('user');
    });

});
