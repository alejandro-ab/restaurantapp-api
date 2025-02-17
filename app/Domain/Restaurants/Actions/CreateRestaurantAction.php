<?php

namespace App\Domain\Restaurants\Actions;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateRestaurantAction
{
    public static function execute(array $data): Restaurant
    {
        /** @var User $user */
        $user = Auth::user();

        $restaurant = Restaurant::query()->make($data);

        $user->restaurants()->save($restaurant);

        if (isset($data['tags'])) {
            $restaurant->tags()->sync($data['tags']);
        }

        return $restaurant;
    }
}
