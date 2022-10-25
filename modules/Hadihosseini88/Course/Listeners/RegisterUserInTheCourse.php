<?php

namespace Hadihosseini88\Course\Listeners;

use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Repositories\CourseRepo;

class RegisterUserInTheCourse
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->payment->paymentable_type == Course::class){
            resolve(CourseRepo::class)->addStudentToCourse($event->payment->paymentable,$event->payment->buyer_id);
        }
    }
}
