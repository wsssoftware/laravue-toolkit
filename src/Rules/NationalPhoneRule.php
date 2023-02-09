<?php

namespace Laravue\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class NationalPhoneRule
 *
 * Created by allancarvalho in fevereiro 09, 2023
 */
class NationalPhoneRule implements ValidationRule
{
    /**
     * @inheritDoc
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = preg_replace('/[^0-9]/is', '', $value);
        $nationalPrefix = ['0300', '0500', '0800', '0900'];
        if (! in_array(substr($value, 0, 4), $nationalPrefix) || strlen($value) !== 11) {
            $fail(__('validation.phone.national'));
        }
    }
}
