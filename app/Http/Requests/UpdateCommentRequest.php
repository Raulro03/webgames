<?php

namespace App\Http\Requests;

use App\Rules\NoPalabrasProhibidas;
use App\Rules\NoParentSelfReference;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{

    protected $commentId;

    protected function prepareForValidation()
    {
        // Laravel automáticamente pasa el {comment} desde la ruta
        $this->commentId = $this->route('comment')->id;
    }

    public function rules(): array
    {
        return [
            'post_id' => ['required'],
            'body' => ['required',new NoPalabrasProhibidas()],
            'parent_id' => ['nullable', new NoParentSelfReference($this->commentId)],
        ];
    }

    public function authorize(): bool
    {
        $comment = $this->route('comment');

        return $this->user()?->can('update', $comment) ?? false;
    }
}
