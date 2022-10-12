<?php

namespace Hadihosseini88\Media\Services;

use Hadihosseini88\Media\Contracts\FileServiceContract;
use Hadihosseini88\Media\Models\Media;


class MediaFileService
{
    private static $file;
    private static $dir;
    private static $isPrivate;

    public static function privateUpload($file)
    {
        self::$file = $file;
        self::$dir = 'private/';
        self::$isPrivate = true;
        return self::upload();
    }

    public static function publicUpload($file)
    {
        self::$file = $file;
        self::$dir = 'public/';
        self::$isPrivate = false;
        return self::upload();
    }

    private static function upload()
    {
        $extension = self::normalizeExtension(self::$file);

        foreach (config('mediaFile.MediaTypeServices') as $type => $service) {
            if (in_array($extension, $service['extensions'])) {
                return self::uploadByHandler(new $service['handler'], $type);
            }
        }
    }

    public static function delete(Media $media)
    {
        foreach (config('mediaFile.MediaTypeServices') as $type => $service){
            if ($media->type == $type){
                return $service['handler']::delete($media);
            }
        }

    }

    /**
     * @param $file
     * @return string
     */
    private static function normalizeExtension($file): string
    {
        return strtolower($file->getClientOriginalExtension());
    }

    private static function fileNameGenerator()
    {
        return uniqid();
    }

    private static function uploadByHandler(FileServiceContract $service, $key): Media
    {

        $media = new Media();
        $media->files = $service::upload(self::$file, self::fileNameGenerator(), self::$dir);
        $media->type = $key;
        $media->user_id = auth()->id();
        $media->filename = self::$file->getClientOriginalName();
        $media->is_private = self::$isPrivate;
        $media->save();
        return $media;
    }

    public static function thumb(Media $media)
    {
        foreach (config('mediaFile.MediaTypeServices') as $type => $service){
            if ($media->type == $type){
                return $service['handler']::thumb($media);
            }
        }
    }

}
