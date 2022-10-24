<?php

namespace Hadihosseini88\Payment\Http\Controllers;


use App\Http\Controllers\Controller;
use Hadihosseini88\Payment\Gateways\Gateway;
use Hadihosseini88\Payment\Models\Payment;
use Hadihosseini88\Payment\Repositories\PaymentRepo;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $getway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();
        $payment = $paymentRepo->findByInvoiceId($getway->getInvoiceIdFromRequest($request));
        if (!$payment) {
            newFeedback('تراکنش ناموفق', 'تراکنش مورد نظر یافت نشد', 'error');
            return redirect('/');
        }

        $result = $getway->verify($payment);


        if (is_array($result)) {
            newFeedback('عملیات ناموفق', $result['message'], 'error');
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_FAIL);
            // todo

        } else {
            // todo success
            newFeedback('عملیات موفق', 'پرداخت با موفقیت انجام شد.');
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_SUCCESS);

        }
        return redirect()->to($payment->paymentable->path());
    }

}
