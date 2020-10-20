<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class File extends Model
{
    protected $fillable = ["path", "file"];

    public static function createFile($file,$file_name, $folder)
    {
        if (count(explode("base64,",$file)) > 1 && File::is_base64_encoded(explode("base64,",$file)[1]))
        {
            $extension = ".".explode('/', mime_content_type($file))[1];
            $fd = [
                'file_name'=>$file_name,
                'extension'=>$extension,
                'folder'=>$folder,
                'file'=>$file
            ];
            return File::mkFile($fd);
        }
    }

    public static function mkFile($data)
    {
        $file = Str::kebab($data['file_name'])."_".time().$data['extension'];
        $storedFile = Storage::disk('local')->putFileAs("public/".$data['folder'], $data['file'], $file);

        $path = "storage/".$data['folder']."/";

        $file = static::create([
                'path'=>$path,
                'file'=>$file
            ]);

        return $file;
    }

    public static function is_base64_encoded($data)
    {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data)) {
        return TRUE;
        } else {
        return FALSE;
        }
    }
}
