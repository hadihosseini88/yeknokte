<?php

namespace Hadihosseini88\User\Models;

use Hadihosseini88\Media\Models\Media;
use Hadihosseini88\User\Notifications\ResetPasswordRequestNotification;
use Hadihosseini88\User\Notifications\VerifyMailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BAN = 'ban';
    static $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_BAN];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyMailNotification());
    }
    public function sendResetPasswordRequestNotification()
    {
        $this->notify(new ResetPasswordRequestNotification());
    }

    public function image()
    {
        return $this->belongsTo(Media::class,'image_id');
    }
}
