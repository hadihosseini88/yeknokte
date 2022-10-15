<?php

namespace Hadihosseini88\Course\Models;

use Hadihosseini88\Media\Models\Media;
use Hadihosseini88\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{

    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    public static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED, self::CONFIRMATION_STATUS_REJECTED, self::CONFIRMATION_STATUS_PENDING];

    const STATUS_OPENED = 'opened';
    const STATUS_LOCKED = 'locked';
    public static $statuses = [self::STATUS_OPENED, self::STATUS_LOCKED];

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function getConfirmationStatusCssClass()
    {
        switch ($this->confirmation_status) {
            case(self::CONFIRMATION_STATUS_ACCEPTED):
                return 'text-success';
                break;
            case(self::CONFIRMATION_STATUS_REJECTED):
                return 'text-error';
                break;
            case(self::CONFIRMATION_STATUS_PENDING):
                return 'text-pending';
                break;
        }
    }

    public function getStatusCssClass()
    {
        switch ($this->statuses) {
            case(self::STATUS_OPENED):
                return 'text-success';
                break;
            case(self::STATUS_LOCKED):
                return 'text-error';
                break;
        }
    }
}
