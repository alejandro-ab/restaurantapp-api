<?php

namespace App\Domain\Auth\Actions\SocialAuth;

use Laravel\Socialite\Contracts\User as SocialiteUser;

class SocialUserResolver
{
    protected SocialiteUser $socialUser;
    protected string $provider;

    public function __construct(SocialiteUser $socialUser, string $provider)
    {
        $this->socialUser = $socialUser;
        $this->provider = $provider;
    }

    public function getEmail(): ?string
    {
        return $this->socialUser->getEmail();
    }

    public function getName(): string
    {
        return $this->socialUser->getName() ?? $this->socialUser->getNickname() ?? 'User';
    }

    public function getProviderId(): string
    {
        return $this->socialUser->getId();
    }

    public function getAvatar(): ?string
    {
        return $this->socialUser->getAvatar();
    }

    public function getUserData(): array
    {
        return [
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'provider_id' => $this->getProviderId(),
            'provider' => $this->provider,
            'avatar' => $this->getAvatar(),
        ];
    }
}
