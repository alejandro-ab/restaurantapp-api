<?php

namespace App\Http\Controllers\V1;

use App\Domain\Auth\Actions\LoginUserAction;
use App\Domain\Auth\Actions\LogoutUserAction;
use App\Domain\Auth\Actions\RegisterUserAction;
use App\Domain\Auth\Actions\ResetPasswordAction;
use App\Domain\Auth\Actions\SendPasswordResetAction;
use App\Domain\Auth\Actions\SocialAuth\HandleGithubAuthAction;
use App\Domain\Auth\Actions\SocialAuth\RedirectToProviderAction;
use App\Domain\Auth\ApiResources\UserResource;
use App\Domain\Auth\Requests\ForgotPasswordRequest;
use App\Domain\Auth\Requests\LoginRequest;
use App\Domain\Auth\Requests\RegisterRequest;
use App\Domain\Auth\Requests\ResetPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Domain\Support\Helpers\ResponseHelper;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterUserAction $registerUserAction): JsonResponse
    {
        $user = $registerUserAction->execute($request->validated());

        return ResponseHelper::success(new UserResource($user), 201);
    }

    /* @throws ValidationException */
    public function login(LoginRequest $request, LoginUserAction $loginUserAction): JsonResponse
    {
        [ 'email' => $email, 'password' => $password, 'device_name' => $device_name ] = $request->validated();

        $token = $loginUserAction->execute(
            $email,
            $password,
            $device_name
        );

        return ResponseHelper::success([
            'token' => $token,
        ]);
    }

    public function logout(Request $request, LogoutUserAction $logoutUserAction): JsonResponse
    {
        $logoutUserAction->execute($request->user());

        return ResponseHelper::success();
    }

    public function forgotPassword(ForgotPasswordRequest $request, SendPasswordResetAction $sendPasswordResetAction): JsonResponse
    {
        $message = $sendPasswordResetAction->execute($request->validated('email'));

        return ResponseHelper::success(['message' => $message]);
    }

    public function resetPassword(ResetPasswordRequest $request, ResetPasswordAction $resetPasswordAction): JsonResponse
    {
        $message = $resetPasswordAction->execute($request->validated());

        return ResponseHelper::success(['message' => $message]);
    }

    public function redirectToProvider(string $provider, RedirectToProviderAction $redirectToProviderAction): JsonResponse
    {
        return response()->json($redirectToProviderAction->execute($provider));
    }

    public function handleProviderCallback(string $provider): JsonResponse
    {
        $data = match ($provider) {
            'github' => (new HandleGithubAuthAction())->execute(),
            // 'google' => (new HandleGoogleAuthAction())->execute(),
            default => ['error' => 'Invalid provider']
        };

        return ResponseHelper::success($data);
    }
}
