<?php

namespace Hadihosseini88\Media\Services;

use Hadihosseini88\Media\Contracts\FileServiceContract;
use Hadihosseini88\Media\Models\Media;
use Illuminate\Support\Facades\Storage;

class ZipFileService extends DefaultFileService implements FileServiceContract
{

    public static function upload($file, $filename, $dir): array
    {
        Storage::putFileAs($dir, $file, $filename . '.' . $file->getClientOriginalExtension());
        return ['zip' => $filename . '.' . $file->getClientOriginalExtension()];
    }

    static function getFilename()
    {
        return (static::$media->is_private ? 'private/' : 'public/') . static::$media->files['zip'];
    }
    public static function thumb(Media $media)
    {
        return url('/img/zip-thumb.png');
    }

}
