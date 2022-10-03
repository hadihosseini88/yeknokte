<?php

namespace Hadihosseini88\Course\Models;

use Hadihosseini88\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    public static $confirmationStatuses =[self::CONFIRMATION_STATUS_ACCEPTED,self::CONFIRMATION_STATUS_REJECTED,self::CONFIRMATION_STATUS_PENDING];

    const STATUS_OPENED = 'opened';
    const STATUS_LOCKED = 'locked';
    public static $statuses = [self::STATUS_OPENED,self::STATUS_LOCKED];

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
