<?php

namespace App\Models;

use Database\Factories\DishFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property int $rating
 * @property string $comments
 * @property int $restaurant_id
 *
 * @property Restaurant $restaurant
 * @property Collection<int, Visit> $visits
 * @property Collection<int, Tag> $tags
 * @property Collection<int, Photo> $photos
 */
class Dish extends Model
{
    /** @use HasFactory<DishFactory> */
    use HasFactory;

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function visits(): BelongsToMany
    {
        return $this->belongsToMany(Visit::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'dish_tag');
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'photoable');
    }
}
