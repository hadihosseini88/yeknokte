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

    public function store($data)
    {
        return Settlement::query()->create([
            'user_id' => auth()->id(),
            'to'=> [
                'cart' => $data['cart'],
                'name' => $data['name'],

            ],
            'amount' => $data['amount']
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



}
