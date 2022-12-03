<?php
namespace Hadihosseini88\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Ticket\Repositories\TicketRepo;

class TicketController extends Controller
{
    public function index(TicketRepo $repo)
    {
        $tickets = $repo->paginateAll();
        return view('Tickets::index',compact('tickets'));
    }

    public function create()
    {
        return view('Tickets::create');
    }

}
