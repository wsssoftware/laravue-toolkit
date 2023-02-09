<?php

namespace Laravue\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class DocumentRule
 *
 * Created by allancarvalho in fevereiro 09, 2023
 */
class DocumentRule implements ValidationRule
{
    /**
     * @inheritDoc
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $document = preg_replace('/[^0-9]/is', '', $value);
        if (strlen($document) === 11) {
            (new CpfRule())($attribute, $value, $fail);
        } elseif (strlen($document) === 14) {
            (new CnpjRule())($attribute, $value, $fail);
        } else {
            $fail(__('validation.document.generic'));
        }
    }
}
