<?php

namespace Hadihosseini88\Ticket\Repositories;

use Hadihosseini88\Ticket\Http\Requests\TicketRequest;
use Hadihosseini88\Ticket\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class TicketRepo
{
    public function paginateAll($userId = null)
    {
        $query = Ticket::query();
        if ($userId){
            $query->where('user_id', $userId);
        }
        return $query->latest()->paginate();
    }

    public function store($title): Model
    {
        return Ticket::query()->create([
            'title' => $title,
            'user_id' => auth()->id(),
        ]);
    }

    public function findOrFailWithReplies($ticket)
    {
        return Ticket::query()->with('replies')->findOrFail($ticket);
    }

    public function setStatus($id, string $status)
    {
        return Ticket::query()->where('id', $id)->update(['status' => $status]);
    }
}
