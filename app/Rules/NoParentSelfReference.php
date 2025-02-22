<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoParentSelfReference implements ValidationRule
{
    protected $commentId;

    public function __construct($commentId)
    {
        $this->commentId = $commentId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == $this->commentId) {
            $fail("El campo {$attribute} no puede ser igual al ID del comentario que se está editando.");
        }
    }
}
