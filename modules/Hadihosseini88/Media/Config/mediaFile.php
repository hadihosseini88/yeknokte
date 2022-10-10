<?php
return [
    'MediaTypeServices' => [
        'image' => [
            'extensions' => ['jpg', 'png', 'jpeg'],
            'handler' => \Hadihosseini88\Media\Services\ImageFileService::class,
        ],
        'video' => [
            'extensions' => ['avi', 'mp4', 'mkv'],
            'handler' => \Hadihosseini88\Media\Services\VideoFileService::class,
        ],
        'zip' => [
            'extensions' => ['zip', 'rar', 'tar'],
            'handler' => \Hadihosseini88\Media\Services\VideoFileService::class,
        ],
    ],
];
