<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\Photo;
use App\Models\Restaurant;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Photo>
 */
class PhotoFactory extends Factory
{
    public function definition(): array
    {
        $photoable = $this->photoable();

        return [
            'url' => fake()->imageUrl,
            'photoable_type' => $photoable,
            'photoable_id' => $photoable::factory(),
        ];
    }

    private function photoable()
    {
        return fake()->randomElement([
           Restaurant::class,
           Dish::class,
           Visit::class,
        ]);
    }
}
