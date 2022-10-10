<?php

namespace Hadihosseini88\Media\Services;

use Hadihosseini88\Media\Contracts\FileServiceContract;
use Hadihosseini88\Media\Models\Media;
use Illuminate\Support\Facades\Storage;

class VideoFileService implements FileServiceContract
{

    public static function upload($file, $filename, $dir): array
    {
        $dir = 'private\\';
        Storage::putFileAs($dir, $file, $filename . '.' . $file->getClientOriginalExtension());
        return ['video' => $dir . $filename . '.' . $file->getClientOriginalExtension()];
    }

    public static function delete(Media $media)
    {
        // TODO: Implement delete() method.
    }
}
