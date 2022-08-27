<?php

namespace Laravue\Enums;

enum CurrencyFormat: string
{
    // Format type to format as currency
    case DEFAULT = 'currency';

    // Format type to format as currency, accounting style (negative numbers in parentheses)
    case ACCOUNTING = 'currency_accounting';
}
