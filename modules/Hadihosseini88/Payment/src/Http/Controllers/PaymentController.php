<?php

namespace Hadihosseini88\Payment\Http\Controllers;


use App\Http\Controllers\Controller;

use Carbon\CarbonPeriod;
use Hadihosseini88\Payment\Events\PaymentWasSuccessful;
use Hadihosseini88\Payment\Gateways\Gateway;
use Hadihosseini88\Payment\Models\Payment;
use Hadihosseini88\Payment\Repositories\PaymentRepo;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(PaymentRepo $paymentRepo)
    {
        $this->authorize('manage', Payment::class);
        $payments = $paymentRepo->paginate();
        $last30DaysTotal = $paymentRepo->getLastNDaysTotal(-30);
        $last30DaysSiteBenefit = $paymentRepo->getLastNDaysSiteBenefit(-30);
        $last30DaysSellerShare = $paymentRepo->getLastNDaysSellerShare(-30);
        $totalSell = $paymentRepo->getLastNDaysTotal();
        $totalBenefit = $paymentRepo->getLastNDaysSiteBenefit();

        $dates = collect();
        foreach (range(-30, 0) as $i) {
            $dates->put(now()->addDays($i)->format("Y-m-d"), 0);
        }

        $summery =  $paymentRepo->getDailySummery($dates);
        return view('Payment::index', compact('payments', 'last30DaysTotal', 'last30DaysSiteBenefit', 'totalSell', 'totalBenefit', 'last30DaysSellerShare', 'summery','dates'));
    }

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
            event(new PaymentWasSuccessful($payment));
            newFeedback('عملیات موفق', 'پرداخت با موفقیت انجام شد.');
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_SUCCESS);

        }
        return redirect()->to($payment->paymentable->path());
    }

}
