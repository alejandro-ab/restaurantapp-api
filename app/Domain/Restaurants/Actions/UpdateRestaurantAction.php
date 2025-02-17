<?php

namespace App\Domain\Restaurants\Actions;

use App\Models\Restaurant;

class UpdateRestaurantAction
{
    public static function execute(array $data, Restaurant $restaurant): Restaurant
    {
        $restaurant->update($data);

        if (isset($data['tags'])) {
            $restaurant->tags()->sync($data['tags']);
        }

        return $restaurant;
    }
}
