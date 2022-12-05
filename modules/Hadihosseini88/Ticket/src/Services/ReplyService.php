<?php

namespace Hadihosseini88\Ticket\Services;

use Hadihosseini88\Media\Services\MediaFileService;
use Hadihosseini88\Ticket\Models\Ticket;
use Hadihosseini88\Ticket\Repositories\ReplyRepo;
use Hadihosseini88\Ticket\Repositories\TicketRepo;
use Illuminate\Http\UploadedFile;

class ReplyService
{
    public static function store(Ticket $ticket, $reply, $attachment)
    {
        $repo = new ReplyRepo();
        $tickerRepo = new TicketRepo();
        $media_id = null;
        if ($attachment && ($attachment instanceof UploadedFile)) {
            $media_id = MediaFileService::privateUpload($attachment)->id;
        }
        $reply = $repo->store($ticket->id, $reply, $media_id);
        if ($reply->user_id != $ticket->user_id) {
            $tickerRepo->setStatus($ticket->id, Ticket::STATUS_REPLIED);
        }else{
            $tickerRepo->setStatus($ticket->id, Ticket::STATUS_OPEN);
        }

        return $reply;
    }
}
