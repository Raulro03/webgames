<?php

namespace App\Rules;

use App\Models\ForbiddenWord;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoPalabrasProhibidas implements ValidationRule
{public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $palabrasProhibidas = ForbiddenWord::where('status', 'accept')->pluck('word')->toArray();

        foreach ($palabrasProhibidas as $palabra) {
            if (stripos($value, $palabra) !== false) {
                $fail("El campo {$attribute} contiene palabras prohibidas.");
                return;
            }
        }
    }
}
