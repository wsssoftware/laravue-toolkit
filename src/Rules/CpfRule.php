<?php

namespace Laravue\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class CpfRule
 *
 * Created by allancarvalho in fevereiro 09, 2023
 */
class CpfRule implements ValidationRule
{
    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_replace('/[^0-9]/is', '', $value);
        if (strlen($cpf) !== 11) {
            $fail(__('validation.document.cpf'));
        }
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $fail(__('validation.document.cpf'));
        }
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $fail(__('validation.document.cpf'));
            }
        }
    }
}
