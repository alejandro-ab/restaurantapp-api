<?php

namespace App\Domain\Restaurants\Actions;

use App\Domain\Dishes\Actions\DeleteDishAction;
use App\Domain\Images\Actions\DeleteImageAction;
use App\Domain\Visits\Actions\DeleteVisitAction;
use App\Models\Dish;
use App\Models\Image;
use App\Models\Restaurant;
use App\Models\Visit;

class DeleteRestaurantAction
{
    public static function execute(Restaurant $restaurant): void
    {
        $restaurant->images()->each(fn(Image $image) => DeleteImageAction::execute($image));
        $restaurant->visits()->each(fn(Visit $visit) => DeleteVisitAction::execute($visit));
        $restaurant->dishes()->each(fn(Dish $dish) => DeleteDishAction::execute($dish));

        $restaurant->delete();
    }
}
