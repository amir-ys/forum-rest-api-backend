<?php


use App\Http\Controllers\API\v1\Threads\AnswerController;
use App\Http\Controllers\API\v1\Threads\ThreadController;
use Illuminate\Support\Facades\Route;

Route::resource('threads', ThreadController::class);
Route::prefix('/threads')->group(function () {
    Route::resource('/answers', AnswerController::class);
});
