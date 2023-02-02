<?php

namespace Laravue\Enums;

/**
 * Class FlashTypes
 *
 * Created by allancarvalho in fevereiro 02, 2023
 */
enum FlashTypes: string
{
    case DEFAULT = 'default';
    case SUCCESS = 'success';
    case INFO = 'info';
    case WARNING = 'warning';
    case ERROR = 'error';
}
