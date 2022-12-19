<?php

namespace Hadihosseini88\User\Models;

use Hadihosseini88\Comment\Models\Comment;
use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Models\Lesson;
use Hadihosseini88\Course\Models\Season;
use Hadihosseini88\Media\Models\Media;
use Hadihosseini88\Payment\Models\Payment;
use Hadihosseini88\Payment\Models\Settlement;
use Hadihosseini88\RolePermissions\Models\Role;
use Hadihosseini88\Ticket\Models\Reply;
use Hadihosseini88\Ticket\Models\Ticket;
use Hadihosseini88\User\Notifications\ResetPasswordRequestNotification;
use Hadihosseini88\User\Notifications\VerifyMailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BAN = 'ban';
    static $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_BAN];

    static $defaultUsers = [
        [
            'email' => 'admin@admin.com',
            'password' => 'demo',
            'name' => 'Admin',
            'role' => Role::ROLE_SUPER_ADMIN
        ]
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


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
        return $this->belongsTo(Media::class, 'image_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function purchases()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'buyer_id');
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketReplies()
    {
        return $this->hasMany(Reply::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function profilePath()
    {
        return null;
        return $this->username ? route('viewProfile', $this->username) : route('viewProfile', 'username');
    }

    public function getThumbAttribute()
    {
        if ($this->image)
            return '/storage/' . $this->image->files[300];

        return '/panel/img/pro.jpg';
    }

    public function studentsCount()
    {
        return \DB::table('courses')
            ->select('course_id')->where('teacher_id',$this->id)
            ->join('course_user','courses.id','=','course_user.course_id')->count();
    }

    public function routeNotificationForSms()
    {
        return $this->mobile; // where `phone` is a field in your users table;
    }
}
