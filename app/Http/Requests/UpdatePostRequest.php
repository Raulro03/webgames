<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'body' => ['required'],
            'published_at' => ['required', 'date'],
            'category_id' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
