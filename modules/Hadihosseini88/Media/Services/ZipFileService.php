<?php

namespace Hadihosseini88\Media\Services;

use Hadihosseini88\Media\Contracts\FileServiceContract;
use Hadihosseini88\Media\Models\Media;
use Illuminate\Support\Facades\Storage;

class ZipFileService implements FileServiceContract
{

    public static function upload($file, $filename, $dir): array
    {
        Storage::putFileAs($dir, $file, $filename . '.' . $file->getClientOriginalExtension());
        return ['zip' => $dir . $filename . '.' . $file->getClientOriginalExtension()];
    }

    public static function delete(Media $media)
    {
        // TODO: Implement delete() method.
    }
}
