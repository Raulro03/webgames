<?php

namespace App\Http\Requests;

use App\Rules\NoPalabrasProhibidas;
use Illuminate\Foundation\Http\FormRequest;

class PlatformsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => ['nullable','string','max:100',new NoPalabrasProhibidas()],
            'release_date' => 'required|date',
            'price' => 'nullable|integer|max:999999',
            'average_rating' => 'nullable|numeric|between:0,9.99',
            'image' => 'nullable|image|',
            'gamesSales' => 'nullable|array',
            'gamesSales.*' => 'required|integer|min:0',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
