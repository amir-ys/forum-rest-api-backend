<?php

namespace App\Http\Controllers\API\V01\Auth;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        (resolve(UserRepo::class))->store($request);
        return response()->json(['meesage' => 'user created successfully'],
            \Illuminate\Http\Response::HTTP_CREATED);
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
        return response()->json(['message' => 'logout successfully'], \Illuminate\Http\Response::HTTP_OK);
    }

    public function user()
    {
        return response()->json(\auth()->user(), \Illuminate\Http\Response::HTTP_OK);
    }
}
