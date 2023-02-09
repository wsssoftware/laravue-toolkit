<?php

namespace Laravue\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class CnpjRule
 *
 * Created by allancarvalho in fevereiro 09, 2023
 */
class CnpjRule implements ValidationRule
{
    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cnpj = preg_replace('/[^0-9]/is', '', $value);
        if (strlen($cnpj) != 14) {
            $fail(__('validation.document.cnpj'));
        }
        if (preg_match('/(\d)\1{10}/', $cnpj)) {
            $fail(__('validation.document.cnpj'));
        }

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        if ($cnpj[12] != ($rest < 2 ? 0 : 11 - $rest)) {
            $fail(__('validation.document.cnpj'));
        }
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        if ($cnpj[13] != ($rest < 2 ? 0 : 11 - $rest)) {
            $fail(__('validation.document.cnpj'));
        }
    }
}
