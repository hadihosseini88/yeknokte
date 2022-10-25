<?php

namespace Hadihosseini88\Payment\Services;

use Hadihosseini88\Payment\Gateways\Gateway;
use Hadihosseini88\Payment\Models\Payment;
use Hadihosseini88\Payment\Repositories\PaymentRepo;
use Hadihosseini88\User\Models\User;

class PaymentService
{
    public static function generate($amount, $paymentable, User $buyer)
    {
        if ($amount <= 0 || is_null($paymentable->id) || is_null($buyer->id)) return false;

        $gateway = resolve(Gateway::class);
        $invoiceId = $gateway->request($amount,$paymentable->title);

        if (is_array($invoiceId)){
            dd($invoiceId);
            // todo
        }

        if (!is_null($paymentable->percent)) {
            $seller_p = $paymentable->percent;
            $seller_share = ($amount / 100) * $seller_p;
            $site_share = $amount - $seller_share;
        } else {
            $seller_p = $seller_share = 0;
            $site_share =$amount;
        }

        return resolve(PaymentRepo::class)->store([
            'buyer_id' => $buyer->id,
            'paymentable_id' => $paymentable->id,
            'paymentable_type' => get_class($paymentable),
            'amount' => $amount,
            'invoice_id' => $invoiceId,
            'gateway' => $gateway->getName(),
            'status' => Payment::STATUS_PENDING,
            'seller_p' => $seller_p,
            'seller_share' => $seller_share,
            'site_share' => $site_share,
        ]);
    }
}

