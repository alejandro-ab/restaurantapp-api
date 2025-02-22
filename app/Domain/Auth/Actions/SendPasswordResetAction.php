<?php

namespace App\Domain\Auth\Actions;

use Illuminate\Support\Facades\Password;

class SendPasswordResetAction
{
    public static function execute(string $email): string
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status !== Password::RESET_LINK_SENT) {
            return __($status);
        }

        return 'Mail sent successfully';
    }
}
