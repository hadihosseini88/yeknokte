<?php

namespace Hadihosseini88\Payment\Providers;


use Hadihosseini88\Payment\Events\PaymentWasSuccessful;
use Hadihosseini88\Payment\Listeners\AddSellersShareToHisAccount;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            AddSellersShareToHisAccount::class,
        ]
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
