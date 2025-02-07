<?php

namespace App\Domain\Visits\Actions;

use App\Models\Visit;

class DeleteVisitAction
{
    public static function execute(Visit $visit): void
    {
        $visit->delete();
    }
}
