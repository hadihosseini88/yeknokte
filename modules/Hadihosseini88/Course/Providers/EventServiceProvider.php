<?php

namespace Hadihosseini88\Course\Providers;


use Hadihosseini88\Course\Listeners\RegisterUserInTheCourse;
use Hadihosseini88\Payment\Events\PaymentWasSuccessful;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            RegisterUserInTheCourse::class,
        ]
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
