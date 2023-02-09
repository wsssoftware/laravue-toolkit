<?php

namespace Laravue\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class CellphonePhoneRule
 *
 * Created by allancarvalho in fevereiro 09, 2023
 */
class CellphonePhoneRule implements ValidationRule
{
    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = preg_replace('/[^0-9]/is', '', $value);
        if (strlen($value) !== 11) {
            $fail(__('validation.phone.cellphone'));

            return;
        }
        if (substr($value, 2, 1) != 9) {
            $fail(__('validation.phone.cellphone'));
        }
    }
}
