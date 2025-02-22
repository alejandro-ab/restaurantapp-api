<?php

namespace App\Domain\Auth\Actions\SocialAuth;

use Laravel\Socialite\Facades\Socialite;

class RedirectToProviderAction
{
    public static function execute(string $provider): array
    {
        $redirectUrl = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return ['url' => $redirectUrl];
    }
}
