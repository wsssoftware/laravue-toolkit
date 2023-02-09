<?php

namespace Laravue\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class LatitudeRule
 *
 * Created by allancarvalho in fevereiro 09, 2023
 */
class LatitudeRule implements ValidationRule
{
    /**
     * @inheritDoc
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_numeric($value) && $value >= -90 && $value <= 90) {
            return;
        }

        $fail(__('validation.latitude'));
    }
}
