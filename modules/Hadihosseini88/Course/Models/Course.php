<?php

namespace Hadihosseini88\Course\Models;

use Hadihosseini88\Category\Models\Category;
use Hadihosseini88\Comment\Models\Comment;
use Hadihosseini88\Course\Repositories\CourseRepo;
use Hadihosseini88\Discount\Models\Discount;
use Hadihosseini88\Discount\Repositories\DiscountRepo;
use Hadihosseini88\Discount\Services\DiscountService;
use Hadihosseini88\Media\Models\Media;
use Hadihosseini88\Payment\Models\Payment;
use Hadihosseini88\Ticket\Models\Ticket;
use Hadihosseini88\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * @var mixed
     */

    protected $guarded = [];

    const TYPE_FREE = 'free';
    const TYPE_CASH = 'cash';
    static $types = [self::TYPE_FREE, self::TYPE_CASH];

    const STATUS_COMPLETED = 'completed';
    const STATUS_NOT_COMPLETED = 'not-completed';
    const STATUS_LOCKED = 'locked';
    public static $statuses = [self::STATUS_COMPLETED, self::STATUS_NOT_COMPLETED, self::STATUS_LOCKED];

    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    public static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED, self::CONFIRMATION_STATUS_REJECTED, self::CONFIRMATION_STATUS_PENDING];

    public function banner()
    {
        return $this->belongsTo(Media::class, 'banner_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function tickets()
    {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function approvedComments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('status', Comment::STATUS_APPROVED);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    public function payment()
    {
        return $this->payments()->latest()->first();
    }

    public function discounts()
    {
        return $this->morphToMany(Discount::class, 'discountable');
    }

    public function getDuration()
    {
        return (new CourseRepo())->getDuration($this->id);
    }

    public function hasStudent($studentId)
    {
        return resolve(CourseRepo::class)->hasStudent($this, $studentId);
    }

    public function formattedDuration()
    {
        $duration = $this->getDuration();
        $h = round($duration / 60) < 10 ? '0' . round($duration / 60) : round($duration / 60);
        $m = ($duration % 60) < 10 ? '0' . ($duration % 60) : ($duration % 60);
        return $h . ':' . $m . ':00';
    }

    public function getFormattedPrice()
    {
        return number_format($this->price);
    }

    public function getDiscount()
    {
        $discountRepo = new DiscountRepo();
        $discount = $discountRepo->getCourseBiggerDiscount($this->id);
        $globalDiscount = $discountRepo->getGlobalBiggerDiscount();
        if ($discount == null && $globalDiscount == null) return null;
        if ($discount == null && $globalDiscount != null) return $globalDiscount;
        if ($discount != null && $globalDiscount == null) return $discount;
        if ($globalDiscount->percent > $discount->percent) return $globalDiscount;
        return $discount;
    }

    public function getDiscountPercent()
    {
        $discount = $this->getDiscount();
        if ($discount) return $discount;
        return null;
    }

    public function getDiscountAmount($percent = null)
    {
        if ($percent == null){
            $discount = $this->getDiscount();
            $percent = $discount ? $discount->percent : 0;
        }
        return DiscountService::calculateDiscountAmount($this->price, $percent);
    }

    public function getFinalPrice($code = null, $withDiscounts = false)
    {
        $discount = $this->getDiscount();
        $amount = $this->price;
        $discounts = [];
        if ($discount){
            $discounts [] = $discount;
            $amount = $this->price - $this->getDiscountAmount($discount);
        }

        if ($code) {
            $repo = new DiscountRepo();
            $discountFromCode = $repo->getValidDiscountByCode($code, $this->id);
            if ($discountFromCode) {
                $discounts [] = $discountFromCode;
                $amount = $amount - DiscountService::calculateDiscountAmount($amount, $discountFromCode->percent);
            }
        }
        if ($withDiscounts)
            return [$amount, $discounts];
        return  $amount;
    }

    public function getFormattedFinalPrice()
    {
        return number_format($this->getFinalPrice());
    }

    public function path()
    {
        return route('singleCourse', $this->id . '-' . $this->slug);
    }

    public function lessonsCount()
    {
        return (new CourseRepo())->getLessonsCount($this->id);
    }

    public function shortUrl()
    {
        return route('singleCourse', $this->id);

    }

    public function downloadLinks(): array
    {
        $links = [];
        foreach (resolve(CourseRepo::class)->getLessons($this->id) as $lesson) {
            $links[] = $lesson->downloadLink();
        }

        return $links;
    }
}
