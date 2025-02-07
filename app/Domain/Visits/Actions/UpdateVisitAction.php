<?php

namespace App\Domain\Visits\Actions;

use App\Models\Visit;

class UpdateVisitAction
{
    public static function execute(array $data, Visit $visit): Visit
    {
        $visit->update($data);

        return $visit;
    }
}
