<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Facades\Documents;

use Illuminate\Support\Facades\Facade;

/**
 * @method static boolean validate(string $cpf)
 * @method static string random()
 *
 * @see \Laravue\Utility\Documents\CNPJ
 */
class CNPJ extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return \Laravue\Utility\Documents\CNPJ::class;
    }
}
