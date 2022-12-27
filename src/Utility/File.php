<?php

namespace Laravue\Utility;

/**
 * Class File
 *
 * Created by allancarvalho in dezembro 27, 2022
 */
class File
{
    /**
     * @param  string  $content
     * @return string
     */
    public function temporaryFile(string $content): string
    {
        $prefix = str(config('app.name', 'laravue'))
            ->snake()
            ->append('_')
            ->toString();
        $path = tempnam(sys_get_temp_dir(), $prefix);
        $file = fopen($path, 'w+');
        if ($file === false) {
            throw new \RuntimeException('Unable to create temporary file');
        }
        if (fwrite($file, $content) === false) {
            throw new \RuntimeException('Unable to write to temporary file');
        }
        if (fclose($file) === false) {
            throw new \RuntimeException('Unable to close temporary file');
        }

        return $path;
    }

    /**
     * @param  string  $fileOrContent
     * @return string
     */
    public function mime(string $fileOrContent): string
    {
        if (is_file($fileOrContent)) {
            $fileOrContent = file_get_contents($fileOrContent);
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        return finfo_buffer($finfo, $fileOrContent);
    }
}
