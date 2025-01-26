<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Restaurant>
 */
class RestaurantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company,
            'location' => fake()->city,
            'comments' => fake()->paragraph,
            'rating' => fake()->numberBetween(1, 5),
            'user_id' => User::factory(),
        ];
    }
}
