<?php

namespace App\Domain\Restaurants\ApiResources;

use App\Domain\Images\ApiResources\ImageDetailResource;
use App\Domain\Tags\ApiResources\TagDetailResource;
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
            'tags' => TagDetailResource::collection($this->tags),
            'images' => ImageDetailResource::collection($this->images),
        ];
    }
}
