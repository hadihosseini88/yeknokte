<?php

namespace Hadihosseini88\Comment\Providers;


use Hadihosseini88\Comment\Events\CommentApprovedEvent;
use Hadihosseini88\Comment\Events\CommentRejectedEvent;
use Hadihosseini88\Comment\Events\CommentSubmittedEvent;
use Hadihosseini88\Comment\Listeners\CommentApprovedListener;
use Hadihosseini88\Comment\Listeners\CommentRejectedListener;
use Hadihosseini88\Comment\Listeners\CommentSubmittedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CommentSubmittedEvent::class => [
            CommentSubmittedListener::class,
        ],
        CommentApprovedEvent::class => [
            CommentApprovedListener::class,
        ],
        CommentRejectedEvent::class => [
            CommentRejectedListener::class,
        ],
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
