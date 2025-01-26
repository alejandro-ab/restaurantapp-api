<?php

namespace App\Domain\Restaurants\Requests;

class CreateRestaurantRequest extends UpdateRestaurantRequest
{
    public function rules(): array
    {
        return array_merge_recursive(parent::rules(), [
            'name' => ['required'],
        ]);
    }
}
