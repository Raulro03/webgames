<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'post_id' => ['required', 'exists:posts'],
            'user_id' => ['required', 'exists:users'],
            'body' => ['required'],
            'published_at' => ['required', 'date'],
            'parent_id' => ['nullable', 'exists:comments'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
