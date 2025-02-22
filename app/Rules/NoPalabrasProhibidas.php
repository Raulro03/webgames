<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoPalabrasProhibidas implements ValidationRule
{
    protected $palabrasProhibidas = ['maldición', 'insulto', 'ofensivo', 'matar' , 'drogas']; // Agrega más palabras si es necesario.

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->palabrasProhibidas as $palabra) {
            if (stripos($value, $palabra) !== false) {
                $fail("El campo {$attribute} contiene palabras prohibidas.");
                return;
            }
        }
    }
}
