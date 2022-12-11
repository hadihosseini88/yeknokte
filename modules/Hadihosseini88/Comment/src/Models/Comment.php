<?php

namespace Hadihosseini88\Comment\Models;

use Hadihosseini88\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    const STATUS_NEW = 'new';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public static $statuses = [
        self::STATUS_NEW,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED,
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function notApprovedComments()
    {
        return $this->hasMany(Comment::class)->where('status', self::STATUS_NEW);
    }

    public function getStatusCssClass()
    {
        if ($this->status == self::STATUS_NEW) return 'text-info';
        if ($this->status == self::STATUS_REJECTED) return 'text-error';
        if ($this->status == self::STATUS_APPROVED) return 'text-success';
    }

}
