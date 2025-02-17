<?php

namespace App\Domain\Dishes\Actions;

use App\Models\Dish;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateDishAction
{
    public static function execute(array $data): Dish
    {
        /** @var User $user */
        $user = Auth::user();

        $dish = Dish::query()->make($data);

        $user->dishes()->save($dish);

        if (isset($data['tags'])) {
            $dish->tags()->sync($data['tags']);
        }

        return $dish;
    }
}
