<?php

namespace Laravue\Facades;

use Illuminate\Support\Facades\Facade;
use Laravue\Enums\CurrencyFormat;
use NumberFormatter;

/**
 * @method static string (int|float $value, int $precision = 3, array $options = []): string
 * @method static string toReadableElapsedTime(int|float $seconds)
 * @method static string toReadableSize(int $value)
 * @method static string toPercentage(int|float $value, int $precision = 2, array $options = [])
 * @method static string format(string|int|float $value, array $options = [])
 * @method static float parseFloat(string $value, array $options = [])
 * @method static string formatDelta(int|float $value, array $options = [])
 * @method static string currency(int|float $value, ?string $currency = null, array $options = [])
 * @method static string getDefaultCurrency()
 * @method static void setDefaultCurrency(string $currency)
 * @method static CurrencyFormat getDefaultCurrencyFormat()
 * @method static void setDefaultCurrencyFormat(CurrencyFormat $currencyFormat)
 * @method static NumberFormatter formatter(array $options = [])
 * @method static void config(string $locale, int $type = NumberFormatter::DECIMAL, array $options = [])
 * @method static string ordinal(float|int $value, array $options = [])
 * @method static string onlyNumbers(string $value)
 *
 * @see \AppCore\Utility\Number
 */
class Number extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return 'utility.number';
    }
}
