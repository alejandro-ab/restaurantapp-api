<?php

namespace App\Domain\Restaurants\Actions;

use App\Domain\Images\Actions\DeleteImageAction;
use App\Models\Image;
use App\Models\Restaurant;

class DeleteRestaurantAction
{
    public static function execute(Restaurant $restaurant): void
    {
        $restaurant->images()->each(fn(Image $image) => DeleteImageAction::execute($image));

        $restaurant->delete();
    }
}
