<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Tests\Unit;

use Laravue\Tests\BaseTest;
use Laravue\Utility\Documents\CPF;

/**
 * Class CPFTest
 *
 * Created by allancarvalho in outubro 11, 2022
 */
class CPFTest extends BaseTest
{
    /**
     * @return void
     */
    public function test_valid_cpf(): void
    {
        $cpf = new CPF();
        $this->assertTrue($cpf->validate('578.624.284-63'));
        $this->assertTrue($cpf->validate('57862428463'));
        $this->assertTrue($cpf->validate('350.173.067-57'));
        $this->assertTrue($cpf->validate('35017306757'));
        $this->assertTrue($cpf->validate('074.600.185-11'));
        $this->assertTrue($cpf->validate('07460018511'));
        $this->assertTrue($cpf->validate('441.618.486-76'));
        $this->assertTrue($cpf->validate('44161848676'));
        $this->assertTrue($cpf->validate('530.056.075-85'));
        $this->assertTrue($cpf->validate('53005607585'));
        $this->assertTrue($cpf->validate('638.555.004-44'));
        $this->assertTrue($cpf->validate('63855500444'));
        $this->assertTrue($cpf->validate('786.872.828-00'));
        $this->assertTrue($cpf->validate('78687282800'));
        $this->assertTrue($cpf->validate('682.164.010-60'));
        $this->assertTrue($cpf->validate('68216401060'));
        $this->assertTrue($cpf->validate('751.148.134-55'));
        $this->assertTrue($cpf->validate('75114813455'));
        $this->assertTrue($cpf->validate('083.081.151-60'));
        $this->assertTrue($cpf->validate('08308115160'));
    }

    /**
     * @return void
     */
    public function test_invalid_cpf(): void
    {
        $cpf = new CPF();
        $this->assertFalse($cpf->validate('578.624.224-63'));
        $this->assertFalse($cpf->validate('57862128463'));
        $this->assertFalse($cpf->validate('350.143.067-57'));
        $this->assertFalse($cpf->validate('35017706757'));
        $this->assertFalse($cpf->validate('074.620.185-11'));
        $this->assertFalse($cpf->validate('07460118511'));
        $this->assertFalse($cpf->validate('441.628.486-76'));
        $this->assertFalse($cpf->validate('44161148676'));
        $this->assertFalse($cpf->validate('530.016.075-85'));
        $this->assertFalse($cpf->validate('53005907585'));
        $this->assertFalse($cpf->validate('638.575.004-44'));
        $this->assertFalse($cpf->validate('63855400444'));
        $this->assertFalse($cpf->validate('786.832.828-00'));
        $this->assertFalse($cpf->validate('78687182800'));
        $this->assertFalse($cpf->validate('682.134.010-60'));
        $this->assertFalse($cpf->validate('68216501060'));
        $this->assertFalse($cpf->validate('751.178.134-55'));
        $this->assertFalse($cpf->validate('75114913455'));
        $this->assertFalse($cpf->validate('083.041.151-60'));
        $this->assertFalse($cpf->validate('08308215160'));

        $this->assertFalse($cpf->validate('578624284633'));
        $this->assertFalse($cpf->validate('5786242846'));
    }

    /**
     * @return void
     */
    public function test_random_cpf(): void
    {
        $cpf = new CPF();
        for ($i = 1; $i <= 30; $i++) {
            $this->assertTrue($cpf->validate($cpf->random()));
        }
    }
}
