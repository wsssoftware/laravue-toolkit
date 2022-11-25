/**
 * @see https://dm4t2.github.io/intl-number-input/playground/
 */

import {Unit} from './Unit';
import {CurrencyDisplay, NumberFormatStyle, NumberInputOptions, UnitDisplay} from 'intl-number-input';

const defaults = {
    locale: 'pt-BR',
    autoSign: true, // Allow negative numbers
    hidePrefixOrSuffixOnFocus: true,
}

export default {
    unit(unit: string|Unit = Unit.Centimeter, options: NumberInputOptions = {}) {
        return {
            ...defaults,
            formatStyle: NumberFormatStyle.Unit,
            unit: unit,
            unitDisplay: UnitDisplay.Narrow,
            autoDecimalDigits: true,
            precision: 2,
            ...options
        }
    },
    currency(options: NumberInputOptions = {}) {
        return {
            ...defaults,
            formatStyle: NumberFormatStyle.Currency,
            currency: 'BRL', // see https://en.wikipedia.org/wiki/ISO_4217|ISO
            currencyDisplay: CurrencyDisplay.Symbol,
            autoDecimalDigits: true,
            precision: 2,
            ...options
        }
    },
    integer(options: NumberInputOptions = {}) {
        return {
            ...defaults,
            formatStyle: NumberFormatStyle.Decimal,
            autoDecimalDigits: false,
            precision: 0,
            ...options
        }
    },
    float(options: NumberInputOptions = {}) {
        return {
            ...defaults,
            formatStyle: NumberFormatStyle.Decimal,
            autoDecimalDigits: true,
            precision: 2,
            ...options
        }
    },
    percentage(options: NumberInputOptions = {}) {
        return {
            ...defaults,
            formatStyle: NumberFormatStyle.Percent,
            autoDecimalDigits: true,
            precision: 2,
            valueRange: {
                min: 0,
                max: 1,
            },
            ...options
        }
    }
}
