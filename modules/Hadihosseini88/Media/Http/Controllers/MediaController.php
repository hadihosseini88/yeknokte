<?php

namespace Hadihosseini88\Media\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Media\Models\Media;
use Hadihosseini88\Media\Services\MediaFileService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function download(Media $media , Request $request)
    {
        if (! $request->hasValidSignature()){
            abort(401);
        }
        return MediaFileService::stream($media);
    }

}
