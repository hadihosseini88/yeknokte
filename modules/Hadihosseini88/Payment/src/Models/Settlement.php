<?php

namespace Hadihosseini88\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $guarded = [];
    const STATUS_PENDING = 'pending';
    const STATUS_SETTLED = 'settled';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CANCELED = 'canceled';

    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_SETTLED,
        self::STATUS_REJECTED,
        self::STATUS_CANCELED,
    ];
}
