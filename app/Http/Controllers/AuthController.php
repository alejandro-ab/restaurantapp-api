<?php

namespace App\Http\Controllers;

use App\Domain\Auth\Actions\LoginUserAction;
use App\Domain\Auth\Actions\RegisterUserAction;
use App\Domain\Auth\ApiResources\UserResource;
use App\Domain\Auth\Requests\LoginRequest;
use App\Domain\Auth\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterUserAction $registerUserAction): JsonResponse
    {
        $user = $registerUserAction->execute($request->validated());

        return response()->json([
            'user' => new UserResource($user),
            'message' => 'User registered successfully',
        ], 201);
    }

    public function login(LoginRequest $request, LoginUserAction $loginUserAction): JsonResponse
    {
        $token = $loginUserAction->execute(
            $request->email,
            $request->password,
            $request->device_name
        );

        return response()->json([
            'token' => $token,
            'message' => 'User logged in successfully',
        ]);
    }
}
