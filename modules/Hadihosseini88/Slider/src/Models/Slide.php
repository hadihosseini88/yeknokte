<?php

namespace Hadihosseini88\Slider\Models;

use Hadihosseini88\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $guarded = [];

    const STATUS_DISABLE = 'disable';
    const STATUS_ENABLE = 'enable';


    public static $statuses = [
        self::STATUS_DISABLE,
        self::STATUS_ENABLE,
    ];

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
