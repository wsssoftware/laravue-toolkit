<?php

namespace Laravue\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class GenericPhoneRule
 *
 * Created by allancarvalho in fevereiro 09, 2023
 */
class GenericPhoneRule implements ValidationRule
{
    protected bool $mustShowNumber = false;

    public function mustShowNumber(): void
    {
        $this->mustShowNumber = true;
    }

    /**
     * @inheritDoc
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = preg_replace('/[^0-9]/is', '', $value);
        $nationalPrefix = ['0300', '0500', '0800', '0900'];
        if (in_array(substr($value, 0, 4), $nationalPrefix)) {
            (new NationalPhoneRule())($attribute, $value, $fail);

            return;
        }
        if (strlen($value) === 10) {
            return;
        }
        if (strlen($value) === 11) {
            (new CellphonePhoneRule())($attribute, $value, $fail);

            return;
        }

        if ($this->mustShowNumber) {
            $fail(__('validation.phone.generic_with_number', ['number' => $value]));
        } else {
            $fail(__('validation.phone.generic'));
        }
    }
}
