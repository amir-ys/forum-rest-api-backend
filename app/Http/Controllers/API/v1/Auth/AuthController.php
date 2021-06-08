<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use App\Responses\AjaxResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        (resolve(UserRepo::class))->store($request);
        return AjaxResponse::created(('user created successfully'));
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(auth()->user(), \Illuminate\Http\Response::HTTP_OK);
        }
        throw ValidationException::withMessages([
            'email' => 'incorrect credentials.'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return AjaxResponse::ok(('user created successfully'));
    }

    public function user()
    {
        $data = [
            \auth()->user(),
            'notifications' => \auth()->user()->unreadNotifications()
        ];
        return AjaxResponse::SendData($data, 200);
    }
}
