<?php

namespace Hadihosseini88\Discount\Providers;


use Hadihosseini88\Discount\Listeners\UpdateUsedDiscountsForPayment;
use Hadihosseini88\Payment\Events\PaymentWasSuccessful;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            UpdateUsedDiscountsForPayment::class,
        ]
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
