<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Utility\Documents;

/**
 * Class CNPJ
 *
 * Created by allancarvalho in outubro 11, 2022
 */
class CNPJ extends DocumentBase
{
    const LIMIT = 14;

    const DIGIT_ONE = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    const DIGIT_TWO = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    public function validate(string $document): bool
    {
        return $this->authenticate($document, self::LIMIT, self::DIGIT_ONE, self::DIGIT_TWO);
    }

    public function random(): string
    {
        return $this->make(self::LIMIT, self::DIGIT_ONE, self::DIGIT_TWO);
    }
}
