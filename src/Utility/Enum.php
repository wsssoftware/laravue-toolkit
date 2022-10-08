<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Utility;

use Exception;
use UnitEnum;

/**
 * Class Enum
 *
 * Created by allancarvalho in outubro 08, 2022
 */
class Enum
{
    /**
     * @param  string|array  $enum
     * @return array
     *
     * @throws \Exception
     */
    public function toArray(string|array $enum): array
    {
        if (is_string($enum)) {
            if (enum_exists($enum)) {
                $cases = $enum::cases();
            } else {
                throw new Exception('Enum not found');
            }
        } else {
            $cases = $enum;
        }
        $values = [];
        foreach ($cases as $case) {
            if (! $case instanceof UnitEnum) {
                throw new Exception('Array must be an array of UnitEnum');
            }
            $values[] = $case->value;
        }

        return $values;
    }
}
