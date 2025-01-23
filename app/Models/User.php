<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 *
 * @property Collection<int, Restaurant> $restaurants
 * @property Collection<int, Visit> $visits
 * @property Collection<int, Dish> $dishes
 * @property Collection<int, Tag> $tags
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }

    public function visits(): HasManyThrough
    {
        return $this->hasManyThrough(Visit::class, Restaurant::class);
    }

    public function dishes(): HasManyThrough
    {
        return $this->hasManyThrough(Dish::class, Restaurant::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
