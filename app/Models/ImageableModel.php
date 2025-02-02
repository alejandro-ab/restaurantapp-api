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
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
