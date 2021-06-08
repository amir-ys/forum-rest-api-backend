<?php


use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('leaderBoard', [\App\Http\Controllers\API\v1\User\UserController::class, 'leaderBoard'])
        ->name('leaderBoard');
});
