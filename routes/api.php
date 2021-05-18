<?php

use App\Http\Controllers\API\v1\Auth\AuthController;
use App\Http\Controllers\API\v1\Channels\ChannelController;
use Illuminate\Support\Facades\Route;

route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/user', [AuthController::class, 'user'])->name('user');
    });

    Route::prefix('channels')->group(function () {
        Route::get('/all', [ChannelController::class, 'getAllChannelList'])->name('channels.all');
        Route::post('/store', [ChannelController::class, 'store'])->name('channels.store');
        Route::patch('/update', [ChannelController::class, 'update'])->name('channels.update');
        Route::delete('/destroy', [ChannelController::class, 'destroy'])->name('channels.destroy');
    });


});
