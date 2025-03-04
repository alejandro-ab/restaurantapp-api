<?php

namespace App\Domain\Visits\Requests;

class CreateVisitRequest extends UpdateVisitRequest
{
    public function rules(): array
    {
        return array_merge_recursive(parent::rules(), [
            'visited_at' => ['required'],
            'restaurant_id' => ['required'],
        ]);
    }
}
