<?php

namespace App\Domain\Auth\Actions;

use App\Models\User;

class LogoutUserAction
{
    public static function execute(User $user): void
    {
        $user->tokens()->delete();
    }
}
