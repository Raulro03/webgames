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
            'constitution' => ['required', 'integer', 'min:0', 'max:10'],
            'strength' => ['required', 'integer', 'min:0', 'max:10'],
            'agility' => ['required', 'integer', 'min:0', 'max:10'],
            'intelligence' => ['required', 'integer', 'min:0', 'max:10'],
            'charisma' => ['required', 'integer', 'min:0', 'max:10'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
