<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:10|max:255',
            'description' => 'nullable|string',
            'release_date' => 'required|date',
            'average_rating' => 'nullable|numeric|between:0,9.99',
            'price' => 'required|integer|max:999999',
            'developer_id' => 'required',
            'platformSales' => 'nullable|array',
            'platformSales.*' => 'required|integer|min:0',
            'characterAppearance' => 'nullable|array',
            'characterAppearance.*' => 'required|date',
            'image' => 'nullable|image',
        ];
    }
}
