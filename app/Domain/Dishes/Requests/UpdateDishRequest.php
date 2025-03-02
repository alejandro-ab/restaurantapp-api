<?php

namespace App\Domain\Dishes\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDishRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'comments' => ['nullable', 'string'],
            'restaurant_id' => ['integer', Rule::exists('restaurants', 'id')->where('user_id', auth()->id())],
            'tags' => ['array'],
            'tags.*' => ['integer', Rule::exists('tags', 'id')->where('user_id', auth()->id())],
        ];
    }
}
