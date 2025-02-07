<?php

namespace App\Domain\Visits\Actions;

use App\Models\Visit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateVisitAction
{
    public static function execute(array $data): Visit
    {
        /** @var User $user */
        $user = Auth::user();

        $visit = Visit::query()->make($data);

        $user->visits()->save($visit);

        return $visit;
    }
}
