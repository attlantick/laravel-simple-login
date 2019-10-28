<?php


namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class File
{
    /**
     * @param UploadedFile $file
     * @param $name
     * @return string
     */
    public static function save(UploadedFile $file, string $name):string{

        $name =  md5($name). '.'. $file->extension();
        Storage::disk('local')
            ->put('public/'.$name,file_get_contents($file));
        return 'storage/'.$name;
    }
}
