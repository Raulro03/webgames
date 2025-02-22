<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LongitudTitulo implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $longitud = strlen($value);

        if ($longitud < 10 || $longitud > 100) {
            $fail("El {$attribute} debe tener entre 10 y 100 caracteres. Actualmente tiene {$longitud}.");
        }
    }
}
