<?php

namespace App\Domain\Visits\ApiResources;

use App\Domain\Images\ApiResources\ImageDetailResource;
use App\Domain\Restaurants\ApiResources\RestaurantSimpleResource;
use App\Models\Visit;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Visit
 */
class VisitListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'visited_at' => $this->visited_at->format('Y/m/d'),
            'restaurant' => new RestaurantSimpleResource($this->restaurant),
            'comments' => $this->comments,
            'images' => ImageDetailResource::collection($this->images->take(1)),
        ];
    }
}
