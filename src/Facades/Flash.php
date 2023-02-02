<?php

namespace Laravue\Facades;

use Laravue\Enums\FlashTypes;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Laravue\Flash\FlashMessage assertHasSuccess()
 * @method static \Laravue\Flash\FlashMessage assertHasError()
 * @method static \Laravue\Flash\FlashMessage assertHasInfo()
 * @method static \Laravue\Flash\FlashMessage assertHasWarning()
 * @method static \Laravue\Flash\FlashMessage assertHasFlashType(FlashTypes $flashTypes)
 * @method static \Laravue\Flash\FlashMessage assertMessageContain(string $message)
 * @method static \Laravue\Flash\FlashMessage assertMessageEqual(string $message)
 * @method static \Laravue\Flash\FlashMessage default(string $message, string|false $faIcon = false)
 * @method static \Laravue\Flash\FlashMessage success(string $message, string $faIcon = 'circle-check')
 * @method static \Laravue\Flash\FlashMessage info(string $message, string $faIcon = 'circle-info')
 * @method static \Laravue\Flash\FlashMessage warning(string $message, string $faIcon = 'triangle-exclamation')
 * @method static \Laravue\Flash\FlashMessage error(string $message, string $faIcon = 'diamond-exclamation')
 * @method static void restoreFlashes()
 * @method static array toArray()
 *
 * @see \Laravue\Flash\Flash
 */
class Flash extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return Flash::class;
    }
}
