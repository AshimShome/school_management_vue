<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Payment\PaystackController;
use App\Http\Controllers\Payment\RazorpayController;

Route::get('/payment/{fee}/fee', [PaymentController::class, 'paymentFee'])->middleware('auth:sanctum');
Route::get('/payment/successfull', [PaymentController::class, 'paymentSuccess'])->name('payment.successfull')->middleware('auth:sanctum');

//Paypal
Route::post('paypal/payment', [PaypalController::class, 'processTransaction'])->name('paypal.post');
Route::get('success-transaction/{fee_id}', [PayPalController::class, 'successTransaction'])->name('paypal.successTransaction');
Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('paypal.cancelTransaction');

// Stripe
Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');

// Razorpay
Route::post('payment', [RazorpayController::class, 'payment'])->name('razorpay.post');

// Paystack
Route::post('paystack/payment', [PaystackController::class, 'redirectToGateway'])->name('paystack.post');
Route::get('/paystack/success', [PaystackController::class, 'successPaystack'])->name('paystack.success');
