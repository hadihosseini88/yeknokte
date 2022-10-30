<?php

namespace Hadihosseini88\Payment\Http\Controllers;

use App\Http\Controllers\Controller;

class SettlementController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('Payment::settlements.create');
    }

    public function store()
    {
        
    }
}
