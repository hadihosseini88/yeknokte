<?php

namespace Hadihosseini88\Course\Models;

use Hadihosseini88\Media\Models\Media;
use Hadihosseini88\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    const TYPE_FREE = 'free';
    const TYPE_CASH = 'cash';
    static $types = [self::TYPE_FREE,self::TYPE_CASH];

    const STATUS_COMPLETED = 'completed';
    const STATUS_NOT_COMPLETED = 'not-completed';
    const STATUS_LOCKED = 'locked';
    public static $statuses = [self::STATUS_COMPLETED,self::STATUS_NOT_COMPLETED,self::STATUS_LOCKED];

    public function banner()
    {
        return $this->belongsTo(Media::class,'banner_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }
}
