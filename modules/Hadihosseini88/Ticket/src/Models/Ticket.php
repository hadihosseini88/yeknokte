<?php

namespace Hadihosseini88\Ticket\Models;

use Hadihosseini88\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
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

}
