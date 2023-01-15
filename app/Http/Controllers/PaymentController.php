<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function paymentFee(Fee $fee)
    {
        if (!$fee || $fee->parent_id != auth()->user()->guardian->id || $fee->status) {
            abort(404);
        }

        $fee->load('student.user', 'type', 'class', 'section');

        return view('payment.payment-fee', compact('fee'));
    }

    public function paymentSuccess()
    {
        // $fee->load('student.user', 'type', 'class', 'section');

        return view('payment.payment-success');
    }
}
