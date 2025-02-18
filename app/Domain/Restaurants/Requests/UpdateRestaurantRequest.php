<?php

namespace App\Domain\Restaurants\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRestaurantRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'comments' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'tags' => ['array'],
            'tags.*' => ['integer', Rule::exists('tags', 'id')->where('user_id', auth()->id())],
        ];
    }
}
