<?php

namespace App\Domain\Visits\Actions;

use App\Domain\Images\Actions\DeleteImageAction;
use App\Models\Image;
use App\Models\Visit;

class DeleteVisitAction
{
    public static function execute(Visit $visit): void
    {
        $visit->images()->each(fn(Image $image) => DeleteImageAction::execute($image));

        $visit->delete();
    }
}
