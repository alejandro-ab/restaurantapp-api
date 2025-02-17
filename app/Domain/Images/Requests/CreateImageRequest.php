<?php

namespace App\Domain\Images\Requests;

use App\Domain\Images\Resolvers\ImageableResolver;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'class' => ['required', Rule::in(array_keys(ImageableResolver::MODEL_MAP))],
            'id' => ['required', 'min:1'],
            'image' => ['required', 'image'],
        ];
    }
}
