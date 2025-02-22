<?php

namespace App\Domain\Auth\Actions\SocialAuth;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class HandleSocialAuthAction
{
    public function execute(string $provider, SocialiteUser $socialUser): array
    {
        $resolvedUser = new SocialUserResolver($socialUser, $provider);
        $userData = $resolvedUser->getUserData();

        $user = User::query()->firstOrCreate(
            ['email' => $userData['email']],
            [
                'name' => $userData['name'],
                'password' => bcrypt(Str::random()),
            ]
        );

        $token = $user->createToken("{$provider}-token")->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }
}
