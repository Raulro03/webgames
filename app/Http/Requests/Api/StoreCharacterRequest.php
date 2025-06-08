<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreCharacterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:100'],

            'statistics.constitution' => ['required', 'integer', 'min:0', 'max:10'],
            'statistics.strength' => ['required', 'integer', 'min:0', 'max:10'],
            'statistics.agility' => ['required', 'integer', 'min:0', 'max:10'],
            'statistics.intelligence' => ['required', 'integer', 'min:0', 'max:10'],
            'statistics.charisma' => ['required', 'integer', 'min:0', 'max:10'],


            'games' => ['nullable', 'array'],
            'games.*.id' => ['required', 'exists:games,id'],
            'games.*.appearance' => ['required', 'date'],
        ];
    }
}
