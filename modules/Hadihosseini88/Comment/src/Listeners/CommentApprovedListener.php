<?php

namespace Hadihosseini88\Comment\Listeners;

use Hadihosseini88\Comment\Notifications\CommentApprovedNotification;
use Hadihosseini88\Comment\Notifications\CommentSubmittedNotification;

class CommentApprovedListener
{

    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        //notify teacher
        if ($event->comment->user_id != $event->comment->commentable->teacher->id)
            $event->comment->commentable->teacher->notify(new CommentSubmittedNotification($event->comment));
        $event->comment->user->notify(new CommentApprovedNotification($event->comment));
    }
}
