<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function authenticate(LoginUserRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'logged in',
                'token' => auth()->user()->createToken(env('APP_NAME'))->plainTextToken,
            ]);
        }

        return response()->json([
            'wrong password or login',
        ], 422);
    }

    public function store(UserRequest $request)
    {
        $this->userService->create($request->validated());

        return response()->json([
            'message' => 'user created successfully'
        ], 201);
    }
}
