<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'body' => ['required'],
            'published_at' => ['required', 'date'],
            'category_id' => ['required'],
            'status' => ['required', 'in:archived,published,not_published'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
