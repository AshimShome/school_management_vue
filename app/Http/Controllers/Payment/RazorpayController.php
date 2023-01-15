<?php

namespace App\Http\Controllers\Payment;

use App\Models\Fee;
use Razorpay\Api\Api;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Traits\PaymentTrait;
use App\Http\Controllers\Controller;

class RazorpayController extends Controller
{
    use PaymentTrait;

    public function payment(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input)  && !empty($input['razorpay_payment_id'])) {
            $payment->capture(array('amount' => $payment['amount']));

            $fee = $this->feePay($request->fee_id);
            $this->createIncomeTransaction($fee->transaction_no, $fee->student_id,$fee->type->name,$fee->amount,'Razorpay');

            return redirect()->route('payment.successfull');
        }
    }
}
