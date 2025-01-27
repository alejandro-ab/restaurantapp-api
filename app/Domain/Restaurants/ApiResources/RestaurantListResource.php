<?php

namespace App\Domain\Restaurants\ApiResources;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Restaurant
 */
class RestaurantListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'comments' => $this->comments,
            'rating' => $this->rating,
            'tags' => $this->tags,
        ];
    }
}
