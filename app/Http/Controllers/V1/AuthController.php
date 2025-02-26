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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Domain\Support\Helpers\ResponseHelper;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = RegisterUserAction::execute($request->validated());

        return ResponseHelper::success(new UserResource($user), Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        [ 'email' => $email, 'password' => $password, 'device_name' => $device_name ] = $request->validated();

        $token = LoginUserAction::execute(
            $email,
            $password,
            $device_name
        );

        return ResponseHelper::success([
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        LogoutUserAction::execute($request->user());

        return ResponseHelper::success();
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $message = SendPasswordResetAction::execute($request->validated('email'));

        return ResponseHelper::success(['message' => $message]);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $message = ResetPasswordAction::execute($request->validated());

        return ResponseHelper::success(['message' => $message]);
    }

    public function redirectToProvider(string $provider): JsonResponse
    {
        return response()->json(RedirectToProviderAction::execute($provider));
    }

    public function handleProviderCallback(string $provider): RedirectResponse
    {
        $data = match ($provider) {
            'github' => HandleGithubAuthAction::execute(),
            default => ['error' => 'Invalid provider']
        };

        if (isset($data['error'])) {
            return redirect('restaurantapp://oauthredirect?error=' . urlencode($data['error']));
        }

        $token = $data['token'];
        return redirect("restaurantapp://oauthredirect?token={$token}");
    }
}
