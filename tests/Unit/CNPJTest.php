<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Tests\Unit;

use Laravue\Tests\BaseTest;
use Laravue\Utility\Documents\CNPJ;

/**
 * Class CPFTest
 *
 * Created by allancarvalho in outubro 11, 2022
 */
class CNPJTest extends BaseTest
{
    /**
     * @return void
     */
    public function test_valid_cpf(): void
    {
        $cnpj = new CNPJ();
        $this->assertTrue($cnpj->validate('70.383.288/0001-06'));
        $this->assertTrue($cnpj->validate('70383288000106'));
        $this->assertTrue($cnpj->validate('70383288000106'));
        $this->assertTrue($cnpj->validate('14.367.711/0001-03'));
        $this->assertTrue($cnpj->validate('82.141.000/0001-76'));
        $this->assertTrue($cnpj->validate('82141000000176'));
        $this->assertTrue($cnpj->validate('82141000000176'));
        $this->assertTrue($cnpj->validate('03.430.513/0001-20'));
        $this->assertTrue($cnpj->validate('84.732.752/0001-37'));
        $this->assertTrue($cnpj->validate('84732752000137'));
        $this->assertTrue($cnpj->validate('84732752000137'));
        $this->assertTrue($cnpj->validate('66.014.352/0001-04'));
        $this->assertTrue($cnpj->validate('33.832.634/0001-60'));
        $this->assertTrue($cnpj->validate('33832634000160'));
        $this->assertTrue($cnpj->validate('33832634000160'));
        $this->assertTrue($cnpj->validate('54.700.444/0001-69'));
        $this->assertTrue($cnpj->validate('87.483.138/0001-77'));
        $this->assertTrue($cnpj->validate('87483138000177'));
        $this->assertTrue($cnpj->validate('87483138000177'));
        $this->assertTrue($cnpj->validate('80.058.381/0001-07'));
    }

    /**
     * @return void
     */
    public function test_invalid_cpf(): void
    {
        $cnpj = new CNPJ();
        $this->assertFalse($cnpj->validate('70.313.288/0001-06'));
        $this->assertFalse($cnpj->validate('70382288000106'));
        $this->assertFalse($cnpj->validate('70385288000106'));
        $this->assertFalse($cnpj->validate('14.357.711/0001-03'));
        $this->assertFalse($cnpj->validate('82.131.000/0001-76'));
        $this->assertFalse($cnpj->validate('82142000000176'));
        $this->assertFalse($cnpj->validate('82148000000176'));
        $this->assertFalse($cnpj->validate('03.460.513/0001-20'));
        $this->assertFalse($cnpj->validate('84.752.752/0001-37'));
        $this->assertFalse($cnpj->validate('84731752000137'));
        $this->assertFalse($cnpj->validate('84735752000137'));
        $this->assertFalse($cnpj->validate('66.034.352/0001-04'));
        $this->assertFalse($cnpj->validate('33.842.634/0001-60'));
        $this->assertFalse($cnpj->validate('33836634000160'));
        $this->assertFalse($cnpj->validate('33838634000160'));
        $this->assertFalse($cnpj->validate('54.730.444/0001-69'));
        $this->assertFalse($cnpj->validate('87.443.138/0001-77'));
        $this->assertFalse($cnpj->validate('87485138000177'));
        $this->assertFalse($cnpj->validate('87488138000177'));
        $this->assertFalse($cnpj->validate('80.038.381/0001-07'));

        $this->assertFalse($cnpj->validate('8748313800017'));
        $this->assertFalse($cnpj->validate('874831380001772'));
    }

    /**
     * @return void
     */
    public function test_random_cpf(): void
    {
        $cnpj = new CNPJ();
        for ($i = 1; $i <= 30; $i++) {
            $this->assertTrue($cnpj->validate($cnpj->random()));
        }
    }
}
