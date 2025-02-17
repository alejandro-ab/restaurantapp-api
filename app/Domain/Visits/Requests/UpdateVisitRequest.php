<?php

namespace App\Domain\Visits\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'visited_at' => ['date'],
            'comments' => ['nullable', 'string'],
            'restaurant_id' => ['integer', 'exists:restaurants,id'],
            'dishes' => ['array'],
            'dishes.*' => ['integer', 'exists:dishes,id'],
        ];
    }
}
