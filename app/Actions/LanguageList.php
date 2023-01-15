<?php

namespace App\Actions;

use Illuminate\Support\Str;

class LanguageList
{
    public static function fileList($path = null)
    {
        $filesArray = [];
        $filePath = $path ? $path : base_path("/resources/js/locales");

        $files = \File::files($filePath);

        foreach ($files as $file) {
            $string = $file->getFilename();
            $fileName = Str::replace('.json', '', $string);

            $path = base_path("/resources/js/locales/{$string}");
            $content =  file_get_contents($path);

            $filesArray[$fileName] = json_decode($content);
        }

        return $filesArray;
    }
}
