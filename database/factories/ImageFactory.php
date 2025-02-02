<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\Image;
use App\Models\Restaurant;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    public function definition(): array
    {
        $imageable = $this->imageable();

        return [
            'path' => fake()->filePath(),
            'imageable_type' => $imageable,
            'imageable_id' => $imageable::factory(),
        ];
    }

    private function imageable()
    {
        return fake()->randomElement([
           Restaurant::class,
           Dish::class,
           Visit::class,
        ]);
    }
}
