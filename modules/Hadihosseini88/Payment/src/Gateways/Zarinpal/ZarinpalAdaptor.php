<?php

namespace Hadihosseini88\Payment\Gateways\Zarinpal;

use Hadihosseini88\Payment\Contracts\Gateway;
use Hadihosseini88\Payment\Models\Payment;

class ZarinpalAdaptor implements Gateway
{

    public function request(Payment $payment)
    {
        $zp = new Zarinpal();
        $callback = [];
        $result = $zp->request('***', $payment->amount, $payment->payentable->title, '', '', $callback);

        if (isset($result["Status"]) && $result["Status"] == 100) {
            return $result['Authority'];
            // Success and redirect to pay
//            $zp->redirect($result["StartPay"]);
        } else {
            // error
            echo "خطا در ایجاد تراکنش";
            echo "<br />کد خطا : " . $result["Status"];
            echo "<br />تفسیر و علت خطا : " . $result["Message"];
        }
    }

    public function verify(Payment $payment)
    {
        // TODO: Implement verify() method.
    }
}
