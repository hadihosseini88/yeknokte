<?php
namespace Hadihosseini88\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Ticket\Http\Requests\ReplyRequest;
use Hadihosseini88\Ticket\Http\Requests\TicketRequest;
use Hadihosseini88\Ticket\Models\Ticket;
use Hadihosseini88\Ticket\Repositories\TicketRepo;
use Hadihosseini88\Ticket\Services\ReplyService;

class TicketController extends Controller
{
    public function index(TicketRepo $repo)
    {
        $tickets = $repo->paginateAll();
        return view('Tickets::index',compact('tickets'));
    }

    public function show($ticket, TicketRepo $ticketRepo)
    {
        $ticket = $ticketRepo->findOrFailWithReplies($ticket);
        return view('Tickets::show',compact('ticket'));
    }

    public function create()
    {
        return view('Tickets::create');
    }

    public function store(TicketRequest $request, TicketRepo $repo)
    {
        $ticket = $repo->store($request->title);
        ReplyService::store($ticket, $request->body, $request->attchment);
        newFeedback();
        return redirect()->route('tickets.index');
    }

    public function reply(Ticket $ticket, ReplyRequest $request)
    {
        ReplyService::store($ticket, $request->body, $request->attchment);
        newFeedback();
        return redirect()->route('tickets.show', $ticket->id);
    }

    public function close(Ticket $ticket, TicketRepo $repo)
    {
        $repo->setStatus($ticket->id, Ticket::STATUS_CLOSE);
        newFeedback();
        return redirect(route('tickets.index'));
    }

}
