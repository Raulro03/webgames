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
            'image' => 'nullable|image|',
            'gamesAppearance' => ['nullable', 'array'],
            'gamesAppearance.*' => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
