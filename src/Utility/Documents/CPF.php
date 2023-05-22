<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Utility\Documents;

/**
 * Class CPF
 *
 * Created by allancarvalho in outubro 11, 2022
 */
class CPF extends DocumentBase
{
    const LIMIT = 11;

    const DIGIT_ONE = [10, 9, 8, 7, 6, 5, 4, 3, 2];

    const DIGIT_TWO = [11, 10, 9, 8, 7, 6, 5, 4, 3, 2];

    public function validate(string $document): bool
    {
        return $this->authenticate($document, self::LIMIT, self::DIGIT_ONE, self::DIGIT_TWO);
    }

    public function random(): string
    {
        return $this->make(self::LIMIT, self::DIGIT_ONE, self::DIGIT_TWO);
    }
}
