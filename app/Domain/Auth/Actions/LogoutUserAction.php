<?php

namespace App\Domain\Auth\Actions;

use App\Models\User;

class LogoutUserAction
{
    public function execute(User $user): void
    {
        $user->tokens()->delete();
    }
}
