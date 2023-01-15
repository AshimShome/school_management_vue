<?php

use Illuminate\Support\Facades\Storage;

function responseSuccess($responseName = null, $data = null, $msg = null)
{
    return response()->json([
        'success' => true,
        $responseName => $data,
        'message' => $msg,
    ], 200);
}

function responseError($msg = 'Something went wrong, please try again', $code = 404)
{
    return response()->json([
        'success' => false,
        'message' => $msg,
    ], $code);
}

function flashSuccess($msg)
{
    session()->flash('success', $msg);
}

function flashError($message = 'Something went wrong, please try again')
{
    session()->flash('error', $message);
}

function uploadFileToStorage($file, string $path)
{
    $file_name = $file->hashName();
    Storage::putFileAs($path, $file,  $file_name);
    return $path . '/' .  $file_name;
}

function uploadFileToPublic($file, string $path)
{
    if ($file && $path) {
        $url = $file->move('uploads/' . $path, $file->hashName());
    } else {
        $url = null;
    }

    return $url;
}

function deleteImage($image)
{
    $oldFile = file_exists(public_path($image));

    if ($oldFile) {
        @unlink(public_path($image));
    }
}

function setEnv($key, $value)
{
    $path = app()->environmentFilePath();

    $escaped = preg_quote('=' . env($key), '/');

    file_put_contents($path, preg_replace(
        "/^{$key}{$escaped}/m",
        "{$key}={$value}",
        file_get_contents($path)
    ));

    return true;
}

function adminSetting()
{
    return \App\Models\AdminSetting::first();
}

function currentSession()
{
    return \App\Models\AdminSetting::value('default_session_id');
}

function checkSetup($type = 'mail')
{
    $paypal_mode = env('PAYPAL_MODE') == 'sandbox' ? 0 : 1;
    $paypal = $paypal_mode ? env('PAYPAL_LIVE_CLIENT_ID') && env('PAYPAL_LIVE_CLIENT_SECRET') : env('PAYPAL_SANDBOX_CLIENT_ID') && env('PAYPAL_SANDBOX_CLIENT_SECRET');
    $stripe = env('STRIPE_KEY') && env('STRIPE_SECRET');
    $razorpay = env('RAZORPAY_KEY') && env('RAZORPAY_SECRET');
    $paystack = env('PAYSTACK_PUBLIC_KEY') && env('PAYSTACK_SECRET_KEY') && env('PAYSTACK_PAYMENT_URL');

    switch ($type) {
        case 'mail':
            $status = env('MAIL_MAILER') && env('MAIL_HOST') && env('MAIL_PORT') && env('MAIL_USERNAME') && env('MAIL_PASSWORD') && env('MAIL_ENCRYPTION') && env('MAIL_FROM_ADDRESS') && env('MAIL_FROM_NAME');
            break;
        case 'payment':
            $status = $paypal || $stripe || $razorpay || $paystack;
            break;
    }

    return $status ? 1 : 0;
}
