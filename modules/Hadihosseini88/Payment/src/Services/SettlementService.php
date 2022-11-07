<?php

namespace Hadihosseini88\Payment\Services;

use Hadihosseini88\Payment\Models\Settlement;
use Hadihosseini88\Payment\Repositories\SettlementRepo;

class SettlementService
{
    public static function store(array $data)
    {
        $repo = new SettlementRepo();
        $repo->store($data);
        auth()->user()->balance -= $data['amount'];
        auth()->user()->save();
        newFeedback();
    }

    public static function upadte(int $settlementId,array $data)
    {
        $repo = new SettlementRepo();

        $settlement = $repo->find($settlementId);
        $check = [Settlement::STATUS_CANCELED, Settlement::STATUS_REJECTED];
        if (!in_array($settlement->status, $check) && in_array($data['status'], $check)) {

            $settlement->user->balance += $settlement->amount;
            $settlement->user->save();
        }

        if ($settlement->user->balance < $settlement->amount){
            newFeedback('ناموفق','موجودی حساب کاربر کافی نمی باشد','error');
            return;
        }

        if (in_array($settlement->status , $check) && in_array($data['status'], [Settlement::STATUS_PENDING,Settlement::STATUS_SETTLED])){
            $settlement->user->balance -= $settlement->amount;
            $settlement->user->save();
        }
        $repo->update($settlementId, $data);
        newFeedback();

    }

}
