<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Visit>
 */
class VisitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'visited_at' => fake()->dateTime,
            'comments' => fake()->paragraph,
            'restaurant_id' => Restaurant::factory(),
            'user_id' => User::factory(),
        ];
    }
}
