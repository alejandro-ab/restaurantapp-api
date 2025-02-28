<?php

namespace App\Models;

use App\Domain\Images\Concerns\Imageable;
use Database\Factories\RestaurantFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property string $name
 * @property ?string $location
 * @property ?string $comments
 * @property ?int $rating
 * @property int $user_id
 * @property User $user
 * @property Collection<int, Visit> $visits
 * @property Collection<int, Dish> $dishes
 * @property Collection<int, Tag> $tags
 */
class Restaurant extends Model implements Imageable
{
    /** @use HasFactory<RestaurantFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'location',
        'comments',
        'rating',
    ];

    protected $casts = [
        'location' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'restaurant_tag');
    }

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getPathPrefix(): string
    {
        return 'images/restaurants';
    }
}
