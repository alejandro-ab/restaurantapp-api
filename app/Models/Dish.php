<?php

namespace App\Models;

use App\Domain\Images\Concerns\Imageable;
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
 * @property ?string $description
 * @property ?float $price
 * @property ?int $rating
 * @property ?string $comments
 * @property int $restaurant_id
 *
 * @property User $user
 * @property Restaurant $restaurant
 * @property Collection<int, Visit> $visits
 * @property Collection<int, Tag> $tags
 */
class Dish extends Model implements Imageable
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getPathPrefix(): string
    {
        return 'images/dishes';
    }
}
