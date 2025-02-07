<?php

namespace App\Domain\Visits\ApiResources;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Visit
 */
class VisitDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'visited_at' => $this->visited_at->toDateTimeString(),
            'comments' => $this->comments,
            'restaurant' => [
                'id' => $this->restaurant->id,
                'name' => $this->restaurant->name,
                'location' => $this->restaurant->location,
                'rating' => $this->restaurant->rating,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'dishes' => $this->dishes->map(function ($dish) {
                return [
                    'id' => $dish->id,
                    'name' => $dish->name,
                    'description' => $dish->description,
                    'price' => $dish->price,
                ];
            }),
            'photos' => $this->photos->map(function ($photo) {
                return [
                    'id' => $photo->id,
                    'url' => $photo->url,
                    'description' => $photo->description,
                ];
            }),
        ];
    }
}
