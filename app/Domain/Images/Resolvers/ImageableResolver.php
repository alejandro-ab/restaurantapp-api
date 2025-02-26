<?php

namespace App\Domain\Images\Resolvers;

use App\Domain\Images\Concerns\Imageable;
use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;

class ImageableResolver
{
    const MODEL_MAP = [
        'RESTAURANT' => Restaurant::class,
        'VISIT' => Visit::class,
        'DISH' => Dish::class,
    ];

    public static function resolve(string $class, int $id): ?Imageable
    {
        /** @var Model $modelClass */
        $modelClass = self::MODEL_MAP[$class];

        return $modelClass::query()->where('user_id', auth()->id())->find($id);
    }
}
