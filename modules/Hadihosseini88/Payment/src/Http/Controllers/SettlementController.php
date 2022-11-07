<?php

namespace Hadihosseini88\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Payment\Http\Requests\SettlementRequest;
use Hadihosseini88\Payment\Repositories\SettlementRepo;
use Hadihosseini88\Payment\Services\SettlementService;

class SettlementController extends Controller
{
    public function index(SettlementRepo $repo)
    {
        $settlements = $repo->latest()->paginate();

        return view('Payment::settlements.index', compact('settlements'));

    }

    public function create()
    {
        return view('Payment::settlements.create');
    }

    public function store(SettlementRequest $request)
    {
        SettlementService::store($request->all());
        return redirect(route('settlements.index'));

    }

    public function edit($settlement,SettlementRepo $repo)
    {
        $settlement = $repo->find($settlement);
        return view('Payment::settlements.edit', compact('settlement'));
    }

    public function update($settlementId,SettlementRequest $request)
    {
        SettlementService::upadte($settlementId, $request->all());
        return redirect(route('settlements.index'));

    }
}
