<?php

namespace App\Http\Controllers\Payment;

use App\Models\Fee;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Traits\PaymentTrait;
use App\Http\Controllers\Controller;

class PaystackController extends Controller
{
    use PaymentTrait;

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway(Request $request)
    {
        $request->validate([
            'fee_id' => 'required',
            'amount' => 'required',
        ]);

        $secret_key = env('PAYSTACK_PUBLIC_KEY');
        $curl = curl_init();
        $callback_url = route('paystack.success'); // url to go to after payment
        $amount = $request->amount * 16 * 100;

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $amount,
                'email' => auth()->user()->email,
                'callback_url' => $callback_url
            ]),
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer " . $secret_key, //replace this with your own test key
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            return redirect()->back()->with('error', $err);
        }

        $tranx = json_decode($response, true);
        session(['paystack_request' => $request->all()]);
        if (!$tranx['status']) {
            return redirect()->back()->with("error", $tranx['message']);
        }
        return redirect($tranx['data']['authorization_url']);
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function successPaystack(Request $request)
    {
        $paystack_request = session('paystack_request');

        if ($request['trxref'] === $request['reference']) {

            $fee = $this->feePay($paystack_request['fee_id']);
            $this->createIncomeTransaction($fee->transaction_no, $fee->student_id,$fee->type->name,$fee->amount,'Paystack');
            return redirect()->route('payment.successfull');
        }

        session()->flash('error', 'Something went wrong.');
        return back();
    }
}
