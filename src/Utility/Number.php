<?php

namespace Laravue\Utility;

use Laravue\Enums\CurrencyFormat;
use NumberFormatter;

class Number
{
    /**
     * A list of number formatters indexed by locale and type
     *
     * @var array<string, array<int, mixed>>
     */
    protected array $_formatters = [];

    /**
     * Default currency used by Number::currency()
     *
     * @var string
     */
    protected string $_defaultCurrency = 'BRL';

    /**
     * Default currency format used by Number::currency()
     *
     * @var \Laravue\Enums\CurrencyFormat
     */
    protected CurrencyFormat $_defaultCurrencyFormat;

    /**
     * @var string
     */
    protected string $locale;

    /**
     * @param  string  $locale
     * @param  \Laravue\Enums\CurrencyFormat  $currencyFormat
     * @param  string  $defaultCurrency
     */
    public function __construct(string $locale, CurrencyFormat $currencyFormat, string $defaultCurrency)
    {
        $this->locale = $locale;
        $this->_defaultCurrency = $defaultCurrency;
        $this->_defaultCurrencyFormat = $currencyFormat;
    }

    /**
     * Formats a number with a level of precision.
     *
     * Options:
     *
     * - `locale`: The locale name to use for formatting the number, e.g. fr_FR
     *
     * @param  int|float  $value A floating point number.
     * @param  int  $precision The precision of the returned number.
     * @param  array<string, mixed>  $options Additional options
     * @return string Formatted float.
     *
     * @link https://book.cakephp.org/4/en/core-libraries/number.html#formatting-floating-point-numbers
     */
    public function precision(int|float $value, int $precision = 3, array $options = []): string
    {
        $formatter = $this->formatter(['precision' => $precision, 'places' => $precision] + $options);

        return $formatter->format((float) $value);
    }

    /**
     * @param  int|float  $seconds
     * @return string
     */
    public function toReadableElapsedTime(int|float $seconds): string
    {
        $seconds = round($seconds);
        $minutes = 0;
        $hours = 0;
        $days = 0;
        while ($seconds >= 86400) {
            $days++;
            $seconds -= 86400;
        }
        while ($seconds >= 3600) {
            $hours++;
            $seconds -= 3600;
        }
        while ($seconds >= 60) {
            $minutes++;
            $seconds -= 60;
        }
        $items = [];
        if ($days > 0) {
            $items[] = trans_choice(':value dia|:value dias', $days, ['value' => $this->format($days, ['precision' => 0])]);
        }
        if ($hours > 0) {
            $items[] = trans_choice(':value hora|:value horas', $hours, ['value' => $this->format($hours, ['precision' => 0])]);
        }
        if ($minutes > 0) {
            $items[] = trans_choice(':value minuto|:value minutos', $minutes, ['value' => $this->format($minutes, ['precision' => 0])]);
        }
        if ($seconds > 0) {
            $items[] = trans_choice(':value segundo|:value segundos', $seconds, ['value' => $this->format($seconds, ['precision' => 0])]);
        }

        return \Laravue\Facades\Text::toList($items);
    }

    /**
     * Returns a formatted-for-humans file size.
     *
     * @param  int  $size Size in bytes
     * @return string Human-readable size
     *
     * @link https://book.cakephp.org/4/en/core-libraries/number.html#interacting-with-human-readable-values
     */
    public function toReadableSize(int $size): string
    {
        return match (true) {
            $size < 1024 => trans_choice(':value byte|:value bytes', $size, ['value' => $this->format($size, ['precision' => 2])]),
            round($size / 1024) < 1024 => __(':value KB', ['value' => $this->format($size / 1024, ['precision' => 2])]),
            round($size / 1024 / 1024, 2) < 1024 => __(':value MB', ['value' => $this->format($size / 1024 / 1024, ['precision' => 2])]),
            round($size / 1024 / 1024 / 1024, 2) < 1024 => __(':value GB', ['value' => $this->format($size / 1024 / 1024 / 1024, ['precision' => 2])]),
            default => __(':value TB', ['value' => $this->format($size / 1024 / 1024 / 1024 / 1024, ['precision' => 2])]),
        };
    }

    /**
     * Formats a number into a percentage string.
     *
     * Options:
     *
     * - `multiply`: Multiply the input value by 100 for decimal percentages.
     * - `locale`: The locale name to use for formatting the number, e.g. fr_FR
     *
     * @param  int|float  $value  A floating point number
     * @param  int  $precision  The precision of the returned number
     * @param  array<string, mixed>  $options  Options
     * @return string Percentage string
     *
     * @link https://book.cakephp.org/4/en/core-libraries/number.html#formatting-percentages
     */
    public function toPercentage(int|float $value, int $precision = 2, array $options = []): string
    {
        $options += ['multiply' => false, 'type' => NumberFormatter::PERCENT];
        if (! $options['multiply']) {
            $value = (float) $value / 100;
        }

        return $this->precision($value, $precision, $options);
    }

    /**
     * Formats a number into the correct locale format
     *
     * Options:
     *
     * - `places` - Minimum number or decimals to use, e.g 0
     * - `precision` - Maximum Number of decimal places to use, e.g. 2
     * - `pattern` - An ICU number pattern to use for formatting the number. e.g #,##0.00
     * - `locale` - The locale name to use for formatting the number, e.g. fr_FR
     * - `before` - The string to place before whole numbers, e.g. '['
     * - `after` - The string to place after decimal numbers, e.g. ']'
     *
     * @param  string|int|float  $value A floating point number.
     * @param  array<string, mixed>  $options An array with options.
     * @return string Formatted number
     */
    public function format(string|int|float $value, array $options = []): string
    {
        $formatter = $this->formatter($options);
        $options += ['before' => '', 'after' => ''];

        return $options['before'].$formatter->format((float) $value).$options['after'];
    }

    /**
     * Parse a localized numeric string and transform it in a float point
     *
     * Options:
     *
     * - `locale` - The locale name to use for parsing the number, e.g. fr_FR
     * - `type` - The formatter type to construct, set it to `currency` if you need to parse
     *    numbers representing money.
     *
     * @param  string  $value A numeric string.
     * @param  array<string, mixed>  $options An array with options.
     * @return float point number
     */
    public function parseFloat(string $value, array $options = []): float
    {
        $formatter = $this->formatter($options);

        return (float) $formatter->parse($value);
    }

    /**
     * Formats a number into the correct locale format to show deltas (signed differences in value).
     *
     * ### Options
     *
     * - `places` - Minimum number or decimals to use, e.g 0
     * - `precision` - Maximum Number of decimal places to use, e.g. 2
     * - `locale` - The locale name to use for formatting the number, e.g. fr_FR
     * - `before` - The string to place before whole numbers, e.g. '['
     * - `after` - The string to place after decimal numbers, e.g. ']'
     *
     * @param  int|float  $value  A floating point number
     * @param  array<string, mixed>  $options  Options list.
     * @return string formatted delta
     */
    public function formatDelta(int|float $value, array $options = []): string
    {
        $options += ['places' => 0];
        $value = number_format((float) $value, $options['places'], '.', '');
        $sign = $value > 0 ? '+' : '';
        $options['before'] = isset($options['before']) ? $options['before'].$sign : $sign;

        return $this->format($value, $options);
    }

    /**
     * Formats a number into a currency format.
     *
     * ### Options
     *
     * - `locale` - The locale name to use for formatting the number, e.g. fr_FR
     * - `fractionSymbol` - The currency symbol to use for fractional numbers.
     * - `fractionPosition` - The position the fraction symbol should be placed
     *    valid options are 'before' & 'after'.
     * - `before` - Text to display before the rendered number
     * - `after` - Text to display after the rendered number
     * - `zero` - The text to use for zero values, can be a string or a number. e.g. 0, 'Free!'
     * - `places` - Number of decimal places to use. e.g. 2
     * - `precision` - Maximum Number of decimal places to use, e.g. 2
     * - `pattern` - An ICU number pattern to use for formatting the number. e.g #,##0.00
     * - `useIntlCode` - Whether to replace the currency symbol with the international
     *   currency code.
     *
     * @param  int|float  $value  Value to format.
     * @param  string|null  $currency  International currency name such as 'USD', 'EUR', 'JPY', 'CAD'
     * @param  array<string, mixed>  $options  Options list.
     * @return string Number formatted as a currency.
     */
    public function currency(int|float $value, ?string $currency = null, array $options = []): string
    {
        $value = (float) $value;
        $currency = $currency ?: $this->getDefaultCurrency();

        if (isset($options['zero']) && ! $value) {
            return $options['zero'];
        }

        $formatter = $this->formatter(['type' => $this->getDefaultCurrencyFormat()] + $options);
        $abs = abs($value);
        if (! empty($options['fractionSymbol']) && $abs > 0 && $abs < 1) {
            $value *= 100;
            $pos = $options['fractionPosition'] ?? 'after';

            return $this->format($value, ['precision' => 0, $pos => $options['fractionSymbol']]);
        }

        $before = $options['before'] ?? '';
        $after = $options['after'] ?? '';

        if (! empty($options['useIntlCode'])) {
            $pattern = preg_replace("/¤\s+/u", '¤ ', $formatter->getPattern());
            $formatter->setPattern($pattern);
        } else {
            $pattern = preg_replace("/¤\s+/u", '¤', $formatter->getPattern());
            $formatter->setPattern($pattern);
        }

        $value = $formatter->formatCurrency($value, $currency);

        return $before.$value.$after;
    }

    /**
     * Getter for default currency
     *
     * @return string Currency
     */
    public function getDefaultCurrency(): string
    {
        return $this->_defaultCurrency;
    }

    /**
     * Setter for default currency
     *
     * @param  string  $currency Default currency string to be used by {@link currency()}
     * if $currency argument is not provided. If null is passed, it will clear the
     * currently stored value
     * @return void
     */
    public function setDefaultCurrency(string $currency): void
    {
        $this->_defaultCurrency = $currency;
    }

    /**
     * Getter for default currency format
     *
     * @return CurrencyFormat Currency Format
     */
    public function getDefaultCurrencyFormat(): CurrencyFormat
    {
        return $this->_defaultCurrencyFormat;
    }

    /**
     * Setter for default currency format
     *
     * @param  \Laravue\Enums\CurrencyFormat  $currencyFormat  Default currency format to be used by currency()
     * if $currencyFormat argument is not provided. If null is passed, it will clear the
     * currently stored value
     * @return void
     */
    public function setDefaultCurrencyFormat(CurrencyFormat $currencyFormat): void
    {
        $this->_defaultCurrencyFormat = $currencyFormat;
    }

    /**
     * Returns a formatter object that can be reused for similar formatting task
     * under the same locale and options. This is often a speedier alternative to
     * using other methods in this class as only one formatter object needs to be
     * constructed.
     *
     * ### Options
     *
     * - `locale` - The locale name to use for formatting the number, e.g. fr_FR
     * - `type` - The formatter type to construct, set it to `currency` if you need to format
     *    numbers representing money or a NumberFormatter constant.
     * - `places` - Number of decimal places to use. e.g. 2
     * - `precision` - Maximum Number of decimal places to use, e.g. 2
     * - `pattern` - An ICU number pattern to use for formatting the number. e.g #,##0.00
     * - `useIntlCode` - Whether to replace the currency symbol with the international
     *   currency code.
     *
     * @param  array<string, mixed>  $options An array with options.
     * @return \NumberFormatter The configured formatter instance
     */
    public function formatter(array $options = []): NumberFormatter
    {
        $type = NumberFormatter::DECIMAL;
        if (! empty($options['type'])) {
            $type = $options['type'];
            if ($options['type'] === CurrencyFormat::DEFAULT) {
                $type = NumberFormatter::CURRENCY;
            } elseif ($options['type'] === CurrencyFormat::ACCOUNTING) {
                $type = NumberFormatter::CURRENCY_ACCOUNTING;
            }
            if ($options['type'] instanceof CurrencyFormat) {
                $options['type'] = $options['type']->value;
            }
        }

        if (! isset($this->_formatters[$this->locale][$type])) {
            $this->_formatters[$this->locale][$type] = new NumberFormatter($this->locale, $type);
        }

        /** @var \NumberFormatter $formatter */
        $formatter = $this->_formatters[$this->locale][$type];

        $formatter = clone $formatter;

        return $this->_setAttributes($formatter, $options);
    }

    /**
     * Set formatter attributes
     *
     * @param  \NumberFormatter  $formatter Number formatter instance.
     * @param  array<string, mixed>  $options See Number::formatter() for possible options.
     * @return \NumberFormatter
     */
    protected function _setAttributes(NumberFormatter $formatter, array $options = []): NumberFormatter
    {
        if (isset($options['places'])) {
            $formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $options['places']);
        }

        if (isset($options['precision'])) {
            $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $options['precision']);
        }

        if (! empty($options['pattern'])) {
            $formatter->setPattern($options['pattern']);
        }

        if (! empty($options['useIntlCode'])) {
            // One of the odd things about ICU is that the currency marker in patterns
            // is denoted with ¤, whereas the international code is marked with ¤¤,
            // in order to use the code we need to simply duplicate the character wherever
            // it appears in the pattern.
            $pattern = trim(str_replace('¤', '¤¤ ', $formatter->getPattern()));
            $formatter->setPattern($pattern);
        }

        return $formatter;
    }

    /**
     * Returns a formatted integer as an ordinal number string (e.g. 1st, 2nd, 3rd, 4th, [...])
     *
     * ### Options
     *
     * - `type` - The formatter type to construct, set it to `currency` if you need to format
     *    numbers representing money or a NumberFormatter constant.
     *
     * For all other options see formatter().
     *
     * @param  float|int  $value An integer
     * @param  array<string, mixed>  $options An array with options.
     * @return string
     */
    public function ordinal(float|int $value, array $options = []): string
    {
        return $this->formatter(['type' => NumberFormatter::ORDINAL] + $options)->format($value);
    }

    /**
     * Remove all characters from string that is not a numeric character
     *
     * @param  string  $value
     * @return string
     */
    public function onlyNumbers(string $value): string
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
}
