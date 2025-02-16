<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'title' => ['required'],
            'body' => ['required'],
            'published_at' => ['required', 'date'],
            'category_id' => ['required', 'exists:forum_categories'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
