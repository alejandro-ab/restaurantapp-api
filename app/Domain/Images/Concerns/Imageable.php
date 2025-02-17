<?php

namespace App\Domain\Images\Concerns;

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property Collection<int, Image> $images
 */
interface Imageable
{
    public function images(): MorphMany;

    public function getPathPrefix(): string;
}
