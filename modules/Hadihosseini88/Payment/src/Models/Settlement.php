<?php

namespace Hadihosseini88\Payment\Models;

use Hadihosseini88\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $guarded = [];

    protected $casts = [
        'to' => 'json',
        'from' => 'json'
    ];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusCssClass()
    {
        if ($this->status == \Hadihosseini88\Payment\Models\Settlement::STATUS_SETTLED) return 'text-success';
        elseif ($this->status == \Hadihosseini88\Payment\Models\Settlement::STATUS_PENDING) return 'text-warning';
        else return 'text-error';

    }

}
