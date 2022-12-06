<?php
namespace Hadihosseini88\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Common\Responses\AjaxResponses;
use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\Ticket\Http\Requests\ReplyRequest;
use Hadihosseini88\Ticket\Http\Requests\TicketRequest;
use Hadihosseini88\Ticket\Models\Reply;
use Hadihosseini88\Ticket\Models\Ticket;
use Hadihosseini88\Ticket\Repositories\TicketRepo;
use Hadihosseini88\Ticket\Services\ReplyService;

class TicketController extends Controller
{
    public function index(TicketRepo $repo)
    {
        if (auth()->user()->can(Permission::PERMISSION_MANAGE_TICKETS)){

        $tickets = $repo->paginateAll();
        }
        else{
            $tickets = $repo->paginateAll(auth()->id());
        }
        return view('Tickets::index',compact('tickets'));
    }

    public function show($ticket, TicketRepo $ticketRepo)
    {
        $ticket = $ticketRepo->findOrFailWithReplies($ticket);
        $this->authorize('show',$ticket);
        return view('Tickets::show',compact('ticket'));
    }

    public function create()
    {
        return view('Tickets::create');
    }

    public function store(TicketRequest $request, TicketRepo $repo)
    {

        $ticket = $repo->store($request->title);
        ReplyService::store($ticket, $request->body, $request->attachment);
        newFeedback();
        return redirect()->route('tickets.index');
    }

    public function reply(Ticket $ticket, ReplyRequest $request)
    {

        $this->authorize('show',$ticket);
        ReplyService::store($ticket, $request->body, $request->attchment);
        newFeedback();
        return redirect()->route('tickets.show', $ticket->id);
    }

    public function close(Ticket $ticket, TicketRepo $repo)
    {
        $this->authorize('show',$ticket);
        $repo->setStatus($ticket->id, Ticket::STATUS_CLOSE);
        newFeedback();
        return redirect(route('tickets.index'));
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        $hasAttachments = Reply::query()->where('ticket_id', $ticket->id)->whereNotNull('media_id')->with('media')->get();
        foreach ($hasAttachments as $reply){
            $reply->media->delete();
        }
        $ticket->delete();
        return AjaxResponses::SuccessResponse();
    }

}
