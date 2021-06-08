<?php


namespace App\Http\Controllers\API\v1\User;


use App\Http\Controllers\Controller;
use App\Repositories\UserRepo;
use App\Responses\AjaxResponse;

class UserController extends Controller
{
    public function notification()
    {
        return AjaxResponse::SendData(auth()->user()->unreadNotifications()->get());

    }

    public function leaderBoard(UserRepo $userRepo)
    {
        return $userRepo->getLeaderBoard();
    }

}