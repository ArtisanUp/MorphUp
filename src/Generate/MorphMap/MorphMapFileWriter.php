<?php

namespace ArtisanUp\MorphUp\Generate\MorphMap;

class MorphMapFileWriter
{
    public function writeFile(MorphMap $morphMap): void
    {
        $directory = storage_path('app/artisan-up/morph-up'); //TODO: Make configurable
        $fileName = 'morph-cache.php';
        $filePath = $directory.DIRECTORY_SEPARATOR.$fileName;

        if (!is_dir($directory)) {
            mkdir($directory);
        }

        file_put_contents(
            $filePath,
            '<?php return '.var_export($morphMap->toArray(), true).';'
        );
    }
}
