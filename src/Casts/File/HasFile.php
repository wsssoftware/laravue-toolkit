<?php

namespace Laravue\Casts\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

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
        static::saving(static::fileSaving());
    }

    /**
     * @return \Closure
     */
    private static function fileDeleting(): \Closure
    {
        return function(Model $model) {
            foreach ((new static)->getCasts() as $cast) {
                if (is_subclass_of($cast, File::class)) {
                    $resut = $cast::deleteFile($model);
                    if ($resut === false) {
                        return false;
                    }
                }
            }
            return true;
        };
    }

    /**
     * @return \Closure
     */
    private static function fileSaving(): \Closure
    {
        return function(Model $model) {
            foreach ((new static)->getCasts() as $key => $cast) {
                if (is_subclass_of($cast, File::class)) {
                    $files = static::getUploadedFile($model->getAttribute($key));
                    if ($files === null) {
                        continue;
                    }
                    $resut = $cast::saveFile($model, $files);
                    if ($resut === false) {
                        return false;
                    }
                    $model->setAttribute($key, $resut);
                }
            }
            return true;
        };
    }

    /**
     * @param  mixed  $value
     * @return \Illuminate\Support\Collection|\Illuminate\Http\UploadedFile|null
     */
    protected static function getUploadedFile(mixed $value): Collection|UploadedFile|null
    {
        if ($value instanceof UploadedFile) {
            return $value;
        }
        if (is_array($value)) {
            $value = collect($value);
        }
        if ($value instanceof Collection) {
            $value = $value->filter(fn($file) => $file instanceof UploadedFile);
            if ($value->count() > 0) {
                return $value;
            }
        }
        return null;
    }
}
