<?php

namespace App\Http\Controllers;

use App\Domain\Auth\Actions\LoginUserAction;
use App\Domain\Auth\Actions\LogoutUserAction;
use App\Domain\Auth\Actions\RegisterUserAction;
use App\Domain\Auth\Actions\ResetPasswordAction;
use App\Domain\Auth\Actions\SendPasswordResetAction;
use App\Domain\Auth\ApiResources\UserResource;
use App\Domain\Auth\Requests\ForgotPasswordRequest;
use App\Domain\Auth\Requests\LoginRequest;
use App\Domain\Auth\Requests\RegisterRequest;
use App\Domain\Auth\Requests\ResetPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function logout(Request $request, LogoutUserAction $logoutUserAction): JsonResponse
    {
        $logoutUserAction->execute($request->user());

        return response()->json([
            'message' => 'User logged out successfully',
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request, SendPasswordResetAction $sendPasswordResetAction): JsonResponse
    {
        $message = $sendPasswordResetAction->execute($request->email);

        return response()->json([
            'message' => $message,
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request, ResetPasswordAction $resetPasswordAction): JsonResponse
    {
        $message = $resetPasswordAction->execute($request->validated());

        return response()->json([
            'message' => $message,
        ]);
    }
}
