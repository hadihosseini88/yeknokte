<?php

namespace Hadihosseini88\Payment\Repositories;

use Hadihosseini88\Payment\Models\Payment;
use Hadihosseini88\User\Models\User;

class PaymentRepo
{
    public static function store($data)
    {

        return Payment::Create([
            'buyer_id' => $data['buyer_id'],
            'paymentable_id' => $data['paymentable_id'],
            'paymentable_type' => $data['paymentable_type'],
            'amount' => $data['amount'],
            'invoice_id' => $data['invoice_id'],
            'gateway' => $data['gateway'],
            'status' => $data['status'],
            'seller_p' => $data['seller_p'],
            'seller_share' => $data['seller_share'],
            'site_share' => $data['site_share']

        ]);


    }

    public function findByInvoiceId($invoiceId)
    {
        return Payment::where('invoice_id',$invoiceId)->first();
    }

    public function changeStatus($id, $status)
    {
        return Payment::where('id',$id)->update(['status'=>$status]);
    }
}
