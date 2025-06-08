<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCharacterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:100'],

            'statistics.constitution' => ['nullable', 'integer', 'min:0', 'max:10'],
            'statistics.strength' => ['nullable', 'integer', 'min:0', 'max:10'],
            'statistics.agility' => ['nullable', 'integer', 'min:0', 'max:10'],
            'statistics.intelligence' => ['nullable', 'integer', 'min:0', 'max:10'],
            'statistics.charisma' => ['nullable', 'integer', 'min:0', 'max:10'],

            'games' => ['nullable', 'array'],
            'games.*.id' => ['required_with:games', 'exists:games,id'],
            'games.*.appearance' => ['required_with:games', 'date'],
        ];
    }
}
