<?php

namespace App\Http\Requests\Api;

use App\Rules\LongitudTitulo;
use App\Rules\NoPalabrasProhibidas;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required',new LongitudTitulo()],
            'body' => ['required', new NoPalabrasProhibidas()],
            'published_at' => ['required', 'date'],
            'category_id' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
