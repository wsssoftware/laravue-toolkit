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
        if (
            $value instanceof UploadedFile ||
            (is_array($value) && $this->validUploadedFilesArray($value)) ||
            ($value instanceof Collection && $this->validUploadedFilesArray($value))
        ) {
            return $this->processFile(
                $model,
                $key,
                is_array($value) ? collect($value) : $value,
                $attributes
            );
        }
        return $value;
    }

    /**
     * @param  array|\Illuminate\Support\Collection  $array  $array
     * @return bool
     */
    private function validUploadedFilesArray(array|Collection $array): bool
    {
        if (is_array($array)) {
            $array = collect($array);
        }
        foreach ($array as $value) {
            if (!$value instanceof UploadedFile) {
                return false;
            }
        }
        return true;
    }

    /**
     * process uploaded file
     */
    abstract protected function processFile(Model $model, string $key, UploadedFile|Collection $file, array $attributes): string|array;

    /**
     * delete uploaded file
     */
    abstract public static function deleteFile(Model $model, string $key, string $value): bool;
}
