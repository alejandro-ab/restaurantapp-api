<?php

namespace App\Domain\Dishes\Requests;

class CreateDishRequest extends UpdateDishRequest
{
    public function rules(): array
    {
        return array_merge_recursive(parent::rules(), [
            'name' => ['required'],
            'restaurant_id' => ['required'],
        ]);
    }
}
