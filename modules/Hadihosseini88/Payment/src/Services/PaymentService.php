<?php

namespace Hadihosseini88\Payment\Services;

use Hadihosseini88\Payment\Models\Payment;
use Hadihosseini88\Payment\Repositories\PaymentRepo;
use Hadihosseini88\User\Models\User;

class PaymentService
{
    public static function generate($amount, $paymentable, User $buyer)
    {
        if ($amount <= 0 || is_null($paymentable->id) || is_null($buyer->id)) return false;

        $invoiceId = 0;
        $gateway = '';

        if (!is_null($paymentable->percent)) {
            $seller_p = $paymentable->percent;
            $seller_share = ($amount / 100) * $seller_p;
            $site_share = $amount - $seller_share;
        } else {
            $seller_p = $seller_share = $site_share = 0;
        }

        return resolve(PaymentRepo::class)->store([
            'buyer_id' => $buyer->id,
            'paymentable_id' => $paymentable->id,
            'paymentable_type' => get_class($paymentable),
            'amount' => $amount,
            'invoice_id' => $invoiceId,
            'gateway' => $gateway,
            'status' => Payment::STATUS_PENDING,
            'seller_p' => $seller_p,
            'seller_share' => $seller_share,
            'site_share' => $site_share,
        ]);


    }
}

