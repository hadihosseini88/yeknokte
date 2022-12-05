<?php

namespace Hadihosseini88\Ticket\Repositories;

use Hadihosseini88\Ticket\Http\Requests\TicketRequest;
use Hadihosseini88\Ticket\Models\Reply;
use Hadihosseini88\Ticket\Models\Ticket;

class ReplyRepo
{

    public function store($ticketId, $body, $mediaId = null)
    {
        return Reply::query()->create([
            'user_id'=>auth()->id(),
            'ticket_id'=>$ticketId,
            'body'=>$body,
            'media_id'=>$mediaId,
        ]);
    }
}
