<?php

namespace Hadihosseini88\Payment\Contracts;

use Hadihosseini88\Payment\Models\Payment;

interface Gateway
{
    public function request(Payment $payment);

    public function verify(Payment $payment);
}

