<?php

namespace Hadihosseini88\Comment\Listeners;

use Hadihosseini88\Comment\Notifications\CommentApprovedNotification;
use Hadihosseini88\Comment\Notifications\CommentRejectedNotification;
use Hadihosseini88\Comment\Notifications\CommentSubmittedNotification;

class CommentRejectedListener
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
        //notify teacher
        if ($event->comment->user_id != $event->comment->commentable->teacher->id)
            $event->comment->commentable->teacher->notify(new CommentSubmittedNotification($event->comment));
        $event->comment->user->notify(new CommentRejectedNotification($event->comment));

    }
}
