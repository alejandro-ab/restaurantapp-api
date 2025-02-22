<?php

namespace App\Domain\Visits\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVisitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'visited_at' => ['date'],
            'comments' => ['nullable', 'string'],
            'restaurant_id' => ['integer', Rule::exists('restaurants', 'id')->where('user_id', auth()->id())],
            'dishes' => ['array'],
            'dishes.*' => ['integer', Rule::exists('dishes', 'id')->where('restaurant_id', $this->get('restaurant_id'))],
        ];
    }
}
