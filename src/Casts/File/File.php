<?php

namespace Laravue\Casts\File;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

/**
 * Class File
 *
 * Created by allancarvalho in fevereiro 16, 2023
 */
abstract class File implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }

    /**
     * process uploaded file
     */
    abstract public static function saveFile(Model $model, UploadedFile|Collection $file): false|string|array;

    /**
     * delete uploaded file
     */
    abstract public static function deleteFile(Model $model): bool;
}
