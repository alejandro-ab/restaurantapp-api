<?php

namespace App\Domain\Auth\Actions\SocialAuth;

use Laravel\Socialite\Facades\Socialite;

class HandleGithubAuthAction
{
    public function execute(): array
    {
        $githubUser = Socialite::driver('github')->stateless()->user();

        return (new HandleSocialAuthAction())->execute('github', $githubUser);
    }
}
