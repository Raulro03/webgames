<?php

namespace App\Http\Requests;

use App\Rules\NoPalabrasProhibidas;
use Illuminate\Foundation\Http\FormRequest;

class CharacterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'age' => ['nullable', 'integer'],
            'description' => ['nullable', new NoPalabrasProhibidas()],
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
