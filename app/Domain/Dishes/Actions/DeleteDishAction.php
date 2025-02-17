<?php

namespace App\Domain\Dishes\Actions;

use App\Domain\Images\Actions\DeleteImageAction;
use App\Models\Dish;
use App\Models\Image;

class DeleteDishAction
{
    public static function execute(Dish $dish): void
    {
        $dish->images()->each(fn(Image $image) => DeleteImageAction::execute($image));

        $dish->delete();
    }
}
