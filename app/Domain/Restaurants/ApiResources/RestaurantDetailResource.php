<?php

namespace App\Domain\Restaurants\ApiResources;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Restaurant
 */
class RestaurantDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'comments' => $this->comments,
            'rating' => $this->rating,
            'visits' => $this->visits,
            'dishes' => $this->dishes,
        ];
    }
}
