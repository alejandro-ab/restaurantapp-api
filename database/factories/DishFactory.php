<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dish>
 */
class DishFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'description' => fake()->sentence,
            'price' => fake()->randomFloat(2, 1, 100),
            'rating' => fake()->numberBetween(1, 5),
            'comments' => fake()->paragraph,
            'restaurant_id' => Restaurant::factory(),
        ];
    }
}
