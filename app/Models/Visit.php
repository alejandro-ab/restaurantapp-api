<?php

namespace App\Models;

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
 *
 * @property User $user
 * @property Restaurant $restaurant
 * @property Collection<int, Dish> $dishes
 */
class Visit extends ImageableModel
{
    /** @use HasFactory<VisitFactory> */
    use HasFactory;

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
}
