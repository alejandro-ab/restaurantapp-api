<?php

namespace App\Models;

use App\Domain\Images\Concerns\Imageable;
use Database\Factories\VisitFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $visited_at
 * @property ?string $comments
 * @property int $restaurant_id
 * @property int $user_id
 *
 * @property User $user
 * @property Restaurant $restaurant
 * @property Collection<int, Dish> $dishes
 */
class Visit extends Model implements Imageable
{
    /** @use HasFactory<VisitFactory> */
    use HasFactory;

    protected $fillable = [
        'visited_at',
        'comments',
        'restaurant_id',
    ];

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class);
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
        return 'images/visits';
    }
}
