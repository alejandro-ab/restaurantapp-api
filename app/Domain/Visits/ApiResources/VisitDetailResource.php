<?php

namespace App\Domain\Visits\ApiResources;

use App\Domain\Images\ApiResources\ImageDetailResource;
use App\Domain\Restaurants\ApiResources\RestaurantSimpleResource;
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
            'visited_at' => $this->visited_at->toDateString(),
            'comments' => $this->comments,
            'restaurant' => new RestaurantSimpleResource($this->restaurant),
            'images' => ImageDetailResource::collection($this->images),
        ];
    }
}
