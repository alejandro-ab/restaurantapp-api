<?php

namespace App\Domain\Dishes\Actions;

use App\Models\Dish;

class UpdateDishAction
{
    public static function execute(array $data, Dish $dish): Dish
    {
        $dish->update($data);

        if (isset($data['tags'])) {
            $dish->tags()->sync($data['tags']);
        }

        return $dish;
    }
}
