<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property Collection<int, Image> $images
 */
abstract class ImageableModel extends Model
{
    const PATH_PREFIX = [
        Restaurant::class => 'restaurants',
        Visit::class => 'visits',
        Dish::class => 'dishes',
    ];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getPathPrefix(): string
    {
        return 'images/' . self::PATH_PREFIX[static::class];
    }
}
