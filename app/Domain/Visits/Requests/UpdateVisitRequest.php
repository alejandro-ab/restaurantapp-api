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
            'restaurant_id' => ['nullable', 'exists:restaurants,id'],
            'user_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
