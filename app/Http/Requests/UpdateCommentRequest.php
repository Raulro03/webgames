<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'post_id' => ['required'],
            'body' => ['required'],
            'parent_id' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
