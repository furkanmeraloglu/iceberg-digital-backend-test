<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(RegisterUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::create(array_merge(
            $request->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'Agent successfully registered',
            'user' => $user
        ], 201);
    }

    public function login(LoginUserRequest $request): \Illuminate\Http\JsonResponse
    {
        if (! $token = auth()->attempt($request->validated()))
        {
            return response()->json(['error' => 'User credentials do not match'], 401);
        }
        return $this->createNewToken($token);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    public function userProfile(): \Illuminate\Http\JsonResponse
    {
        return response()->json(auth()->user());
    }
    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->createNewToken(auth()->refresh());
    }
    protected function createNewToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,   // Expires access token in defined duration = 3600s.
            'user' => auth()->user()
        ]);
    }
}
