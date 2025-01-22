<?php

namespace Database\Factories;

use App\Models\Label;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Label>
 */
class LabelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'color' => $this->faker->hexColor,
            'user_id' => User::factory(),
        ];
    }
}
