<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Utility;

use Exception;
use Illuminate\Support\Collection;
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
     * @param  bool  $sort
     * @return array
     * @throws \Exception
     */
    public function pluck(string|array $enum, bool $sort = true): array
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
            $key = $case->value;
            if (method_exists($case, 'getLabel')) {
                $value = $case->getLabel();
            } elseif (method_exists($case, 'label')) {
                $value = $case->label();
            } elseif (method_exists($case, 'getName')) {
                $value = $case->getName();
            } elseif (method_exists($case, 'name')) {
                $value = $case->name();
            } else {
                $value = $case->value;
            }
            $values[$key] = $value;
        }
        if ($sort) {
            uasort($values, function ($a, $b) {
                $at = iconv('UTF-8', 'ASCII//TRANSLIT', $a);
                $bt = iconv('UTF-8', 'ASCII//TRANSLIT', $b);

                return strcmp($at, $bt);
            });
        }
        return $values;
    }

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
