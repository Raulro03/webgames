<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharacterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'age' => ['nullable', 'integer'],
            'description' => ['nullable'],
            'image_url' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
