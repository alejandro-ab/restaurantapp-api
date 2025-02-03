<?php

namespace App\Domain\Images\Resolvers;

use App\Models\Dish;
use App\Models\ImageableModel;
use App\Models\Restaurant;
use App\Models\Visit;

class ImageableResolver
{
    const MODEL_MAP = [
        'RESTAURANT' => Restaurant::class,
        'VISIT' => Visit::class,
        'DISH' => Dish::class,
    ];

    public static function resolve(string $class, int $id): ImageableModel
    {
        $modelClass = self::MODEL_MAP[$class];

        return $modelClass::query()->findOrFail($id);
    }
}
