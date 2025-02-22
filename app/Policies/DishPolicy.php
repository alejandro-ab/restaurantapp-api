<?php

namespace App\Policies;

use App\Models\Dish;
use App\Models\User;

class DishPolicy
{
    public function view(User $user, Dish $dish): bool
    {
        return $dish->user_id === $user->id;
    }

    public function update(User $user, Dish $dish): bool
    {
        return $dish->user_id === $user->id;
    }

    public function delete(User $user, Dish $dish): bool
    {
        return $dish->user_id === $user->id;
    }
}
