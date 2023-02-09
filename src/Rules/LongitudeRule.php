<?php

namespace Laravue\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class LongitudeRule
 *
 * Created by allancarvalho in fevereiro 09, 2023
 */
class LongitudeRule implements ValidationRule
{
    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_numeric($value) && $value >= -180 && $value <= 180) {
            return;
        }

        $fail(__('validation.longitude'));
    }
}
