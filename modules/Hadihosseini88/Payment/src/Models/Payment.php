<?php

namespace Hadihosseini88\Payment\Models;

use Hadihosseini88\Discount\Models\Discount;
use Hadihosseini88\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];
    const STATUS_PENDING = 'pending';
    const STATUS_CANCELED = 'canceled';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL = 'fail';

    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_CANCELED,
        self::STATUS_SUCCESS,
        self::STATUS_FAIL,
    ];

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_payment');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');

    }
}
