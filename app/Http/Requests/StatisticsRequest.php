<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatisticsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'character_id' => ['required', 'integer'],
            'constitution' => ['required', 'integer'],
            'strength' => ['required', 'integer'],
            'agility' => ['required', 'integer'],
            'intelligence' => ['required', 'integer'],
            'charisma' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
