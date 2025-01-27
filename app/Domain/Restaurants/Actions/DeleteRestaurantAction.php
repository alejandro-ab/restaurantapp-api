<?php

namespace App\Domain\Restaurants\Actions;

use App\Models\Restaurant;

class DeleteRestaurantAction
{
    public static function execute(Restaurant $restaurant): void
    {
        $restaurant->delete();
    }
}
