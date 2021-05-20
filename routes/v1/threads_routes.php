<?php


use App\Http\Controllers\API\v1\Threads\ThreadController;
use Illuminate\Support\Facades\Route;

Route::prefix('threads')->group(function () {
    Route::resource('threads' , ThreadController::class);
});
