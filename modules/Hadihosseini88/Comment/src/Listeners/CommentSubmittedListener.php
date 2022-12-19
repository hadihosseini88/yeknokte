<?php

namespace Hadihosseini88\Comment\Listeners;

use Hadihosseini88\Comment\Notifications\CommentSubmittedNotification;

class CommentSubmittedListener
{

    public function __construct()
    {
        //
    }

    public function handle($event)
    {

        //notify owner
        if ($event->comment->comment_id && $event->comment->user_id != $event->comment->comment->user->id)
            $event->comment->comment->user->notify(new CommentSubmittedNotification($event->comment));
    }
}
