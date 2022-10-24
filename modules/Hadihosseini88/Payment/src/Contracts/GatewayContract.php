<?php

namespace Hadihosseini88\Payment\Contracts;

use Hadihosseini88\Payment\Models\Payment;
use Illuminate\Http\Request;

interface GatewayContract
{
    public function request($amount, $description);

    public function verify(Payment $payment);

    public function redirect();

    public function getName();
}

