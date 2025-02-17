<?php

namespace App\Domain\Tags\Requests;

class CreateTagRequest extends UpdateTagRequest
{
    public function rules(): array
    {
        return array_merge_recursive(parent::rules(), [
            'name' => ['required'],
            'color' => ['required'],
        ]);
    }
}
