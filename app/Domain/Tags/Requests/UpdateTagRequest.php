<?php

namespace App\Domain\Tags\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'color' => ['hex_color'],
        ];
    }
}
