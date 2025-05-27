<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreForbiddenWordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'word' => 'required|string|max:100|unique:forbidden_words,word',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
