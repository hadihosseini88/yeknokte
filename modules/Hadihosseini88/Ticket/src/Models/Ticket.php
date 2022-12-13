<?php

namespace Hadihosseini88\Ticket\Models;

use Hadihosseini88\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];
//    protected $table = 'tickets';

    const STATUS_OPEN = 'open';
    const STATUS_CLOSE = 'close';
    const STATUS_PENDING = 'pending';
    const STATUS_REPLIED = 'replied';

    public static $statuses = [
        self::STATUS_OPEN,
        self::STATUS_CLOSE,
        self::STATUS_PENDING,
        self::STATUS_REPLIED,
    ];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function ticketable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusCssClass()
    {
        if ($this->status == self::STATUS_OPEN) return 'text-info';
        if ($this->status == self::STATUS_CLOSE) return 'text-error';
        if ($this->status == self::STATUS_PENDING) return 'text-warning';
        if ($this->status == self::STATUS_REPLIED) return 'text-success';
    }

}
