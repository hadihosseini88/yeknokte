<?php

namespace Hadihosseini88\Discount\Models;

use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Payment\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    const TYPE_ALL = 'all';
    const TYPE_SPECIAL = 'special';
    public static $types = [
        self::TYPE_ALL,
        self::TYPE_SPECIAL,
    ];
    protected $guarded = [];
    protected $casts = [
        'expire_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->morphedByMany(Course::class,'discountable');
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class,'discount_payment');
    }
}
