<?php

namespace App\Domain\Dishes\ApiResources;

use App\Domain\Images\ApiResources\ImageDetailResource;
use App\Domain\Tags\ApiResources\TagDetailResource;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Dish
 */
class DishListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'comments' => $this->comments,
            'rating' => $this->rating,
            'tags' => TagDetailResource::collection($this->tags),
            'images' => ImageDetailResource::collection($this->images->take(1)),
        ];
    }
}
