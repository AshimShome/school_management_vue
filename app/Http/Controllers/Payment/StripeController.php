<?php

namespace App\Http\Controllers\Payment;

use Stripe\Stripe;
use App\Models\Fee;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Traits\PaymentTrait;
use App\Http\Controllers\Controller;

class StripeController extends Controller
{
    use PaymentTrait;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $fee = $this->feePay($request->fee_id);
            $this->createIncomeTransaction($fee->transaction_no, $fee->student_id,$fee->type['name'],$fee->amount,'Stripe');
            return redirect()->route('payment.successfull');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
