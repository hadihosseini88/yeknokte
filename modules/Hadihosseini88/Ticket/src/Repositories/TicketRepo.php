<?php

namespace Hadihosseini88\Ticket\Repositories;

use Hadihosseini88\Ticket\Models\Ticket;

class TicketRepo
{
    public function paginateAll()
    {
        return Ticket::query()->latest()->paginate();
    }
}
