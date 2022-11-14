<?php

namespace Hadihosseini88\Discount\Models;

use Hadihosseini88\Course\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $guarded = [];
    protected $casts = [
        'expire_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->morphedByMany(Course::class,'discountable');
    }
}
