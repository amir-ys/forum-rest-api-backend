<?php


use App\Http\Controllers\API\v1\Threads\AnswerController;
use App\Http\Controllers\API\v1\Threads\ThreadController;
use App\Http\Controllers\API\v1\Threads\SubscribeController;
use Illuminate\Support\Facades\Route;

Route::resource('threads', ThreadController::class);

Route::prefix('/threads')->group(function () {
    Route::resource('/answers', AnswerController::class);

    Route::post('/{thread}/subscribe', [SubscribeController::class, 'subscribe'])->name('subscribe');
    Route::delete('/{thread}/unsubscribe', [SubscribeController::class, 'Unsubscribe'])->name('unSubscribe');
});
