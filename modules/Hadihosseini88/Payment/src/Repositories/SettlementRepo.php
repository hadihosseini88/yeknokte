<?php

namespace Hadihosseini88\Payment\Repositories;

use Hadihosseini88\Payment\Models\Settlement;

class SettlementRepo
{

    private $query;

    public function __construct()
    {
        $this->query = Settlement::query();
    }

    public function store(array $request)
    {
        return Settlement::query()->create([
            'user_id' => auth()->id(),
            'to' => [
                'cart' => $request['cart'],
                'name' => $request['name'],

            ],
            'amount' => $request['amount'],
        ]);
    }

    public function update(int $id,array $request)
    {
        return $this->query->where('id',$id)->update([
            'from' => [
                'name' => $request['from']['name'],
                'cart'=> $request['from']['cart']
            ],
            'to'=> [
                'name' => $request['to']['name'],
                'cart'=> $request['to']['cart']
            ],
            'status' => $request['status']
        ]);
    }

    public function paginate()
    {
        return $this->query->paginate();

    }

    public function Settled()
    {
        return $this->query->where('status', Settlement::STATUS_SETTLED);
    }

    public function find($settlement)
    {
        return $this->query->findOrFail($settlement);
    }

    public function latest()
    {
        return $this->query->latest();
    }

}
