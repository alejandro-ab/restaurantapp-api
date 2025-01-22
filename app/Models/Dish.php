<?php

namespace App\Models;

use Database\Factories\DishFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
 * @property Collection<int, Label> $labels
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

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'dish_label');
    }
}
