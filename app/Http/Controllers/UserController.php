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
    public function authenticate(Request $request)
    {
        if (Auth::attempt($request->all())) {
            return response()->json([
                'message' => 'logged in',
                'token' => auth()->user()->createToken(env('APP_NAME'))->plainTextToken,
            ]);
        }

        return response()->json([
            'wrong password or login',
        ], 422);
    }

    public function store(Request $request)
    {
        if (!(auth()->user() && auth()->user()->hasRole('Super Admin'))) {
            return response()->json([
                'message' => 'user don´t have permission'
            ], 403);
        }
        $user = User::create($request->all());
        $user->assignRole('Super Admin');

        return response()->json([
            'message' => 'user created successfully'
        ], 201);
    }
}
