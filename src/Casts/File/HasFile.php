<?php

namespace Laravue\Casts\File;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait HasFile
 *
 * Created by allancarvalho in fevereiro 16, 2023
 */
trait HasFile
{

    /**
     * @return void
     */
    public static function bootHasFile(): void
    {
        static::deleting(static::fileDeleting());
    }

    /**
     * @return \Closure
     */
    private static function fileDeleting(): \Closure
    {
        return function(Model $model) {
            foreach ((new static)->getCasts() as $key => $cast) {
                if (is_subclass_of($cast, File::class)) {
                    $resut = $cast::deleteFile($model, $key, $model->getAttribute($key));
                    if ($resut === false) {
                        return false;
                    }
                }
            }
            return true;
        };
    }
}
