<?php

namespace App\Domain\Visits\ApiResources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'visited_at' => $this->visited_at,
            'restaurant' => $this->restaurant->name,
            'user' => $this->user->name,
        ];
    }
}
