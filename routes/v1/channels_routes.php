<?php


use App\Http\Controllers\API\v1\Channels\ChannelController;
use Illuminate\Support\Facades\Route;

Route::prefix('channels')->group(function () {
    Route::get('/all', [ChannelController::class, 'getAllChannelList'])->name('channels.all');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/store', [ChannelController::class, 'store'])->name('channels.store');
        Route::patch('/update', [ChannelController::class, 'update'])->name('channels.update');
        Route::delete('/destroy', [ChannelController::class, 'destroy'])->name('channels.destroy');
    });
});
