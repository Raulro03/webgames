<?php

namespace App\Http\Requests;

use App\Rules\NoPalabrasProhibidas;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'post_id' => ['required'],
            'body' => ['required',new NoPalabrasProhibidas()],
            'parent_id' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
