<?php

namespace App\Domain\Visits\ApiResources;

use App\Domain\Images\ApiResources\ImageDetailResource;
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
            'visited_at' => $this->visited_at->toDateString(),
            'restaurant' => $this->restaurant->name,
            'comments' => $this->comments,
            'images' => ImageDetailResource::collection($this->images->take(1)),
        ];
    }
}
