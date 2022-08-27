<?php

namespace Laravue\Tests\Unit;

use Laravue\Enums\CurrencyFormat;
use Laravue\Tests\BaseTest;
use Laravue\Utility\Number;

class NumberTest extends BaseTest
{
    /**
     * @return void
     */
    public function test_precision_check()
    {
        $number = new Number('pt_BR', CurrencyFormat::DEFAULT, 'BRL');
        $this->assertEquals('12,212', $number->precision(12.2122, 3));
        $this->assertEquals('12,213', $number->precision(12.2127, 3));
        $this->assertEquals('0,0', $number->precision(0.03, 1));
        $this->assertEquals('0,1', $number->precision(0.07, 1));
    }

    /**
     * @return void
     */
    public function test_to_percentage_check()
    {
        $number = new Number('pt_BR', CurrencyFormat::DEFAULT, 'BRL');
        $this->assertEquals('20,3%', $number->toPercentage(20.33, 1));
        $this->assertEquals('20,4%', $number->toPercentage(20.37, 1));
        $this->assertEquals('10,300%', $number->toPercentage(10.3, 3));
        $this->assertEquals('100%', $number->toPercentage(100, 0));
        $this->assertEquals('0%', $number->toPercentage(0, 0));
        $this->assertEquals('50%', $number->toPercentage(50, 0));
    }

    /**
     * @return void
     */
    public function test_format_check()
    {
        $number = new Number('pt_BR', CurrencyFormat::DEFAULT, 'BRL');
        $this->assertEquals('20,33', $number->format(20.33, ['places' => 2, 'precision' => 2]));
        $this->assertEquals('10', $number->format(10.000));
        $this->assertEquals('10abc', $number->format(10.000, ['after' => 'abc']));
        $this->assertEquals('abc10', $number->format(10.000, ['before' => 'abc']));
    }

    /**
     * @return void
     */
    public function test_format_delta_check()
    {
        $number = new Number('pt_BR', CurrencyFormat::DEFAULT, 'BRL');
        $this->assertEquals('+20', $number->formatDelta(20));
        $this->assertEquals('-20', $number->formatDelta(-20));
    }

    /**
     * @return void
     */
    public function test_currency_check()
    {
        $number = new Number('pt_BR', CurrencyFormat::DEFAULT, 'BRL');
        $this->assertEquals('R$20,00', $number->currency(20));
        $this->assertEquals('-R$20,00', $number->currency(-20));

        $this->assertEquals('nada', $number->currency(0, 'BRL', ['zero' => 'nada']));
        $this->assertEquals('R$20,00', $number->currency(20, 'BRL', ['zero' => 'nada']));

        $this->assertEquals('BRL 20,00', $number->currency(20, 'BRL', ['useIntlCode' => true]));

        $this->assertEquals('10cents', $number->currency(0.1, 'BRL', ['fractionSymbol' => 'cents']));
        $this->assertEquals('cents10', $number->currency(0.1, 'BRL', ['fractionSymbol' => 'cents', 'fractionPosition' => 'before']));

        $number->setDefaultCurrency('USD');
        $this->assertEquals('US$20,00', $number->currency(20));
        $this->assertEquals('-US$20,00', $number->currency(-20));

        $number->setDefaultCurrency('BRL');
        $number->setDefaultCurrencyFormat(CurrencyFormat::ACCOUNTING);
        $this->assertEquals('R$20,00', $number->currency(20));
        $this->assertTrue(in_array($number->currency(-20), ['-R$20,00', '(R$20,00)']));
    }

    /**
     * @return void
     */
    public function test_ordinal_check()
    {
        $number = new Number('pt_BR', CurrencyFormat::DEFAULT, 'BRL');
        $this->assertEquals('1º', $number->ordinal(1));
        $this->assertEquals('2º', $number->ordinal(2));
        $this->assertEquals('3º', $number->ordinal(3));
    }

    /**
     * @return void
     */
    public function test_patern_check()
    {
        $number = new Number('pt_BR', CurrencyFormat::DEFAULT, 'BRL');
        $this->assertEquals('32 kg', $number->format(32, ['pattern' => '#0.# kg']));
    }

    /**
     * @return void
     */
    public function test_parse_float_check()
    {
        $number = new Number('pt_BR', CurrencyFormat::DEFAULT, 'BRL');
        $this->assertEquals(20.21, $number->parseFloat('20,21'));
    }
}
