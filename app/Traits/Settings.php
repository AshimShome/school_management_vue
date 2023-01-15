<?php

namespace App\Traits;

use msztorc\LaravelEnv\Env;

trait Settings
{

    public function paypalSetting($request)
    {
        $mode = $request->paypal_mode;

        setEnv('PAYPAL_MODE', $mode ? 'live' : 'sandbox');

        if ($mode) {
            setEnv('PAYPAL_LIVE_CLIENT_ID', $request->paypal_key);
            setEnv('PAYPAL_LIVE_CLIENT_SECRET', $request->paypal_secret);
        } else {
            setEnv('PAYPAL_SANDBOX_CLIENT_ID', $request->paypal_key);
            setEnv('PAYPAL_SANDBOX_CLIENT_SECRET', $request->paypal_secret);
        }
    }

    public function stripeSetting($request)
    {
        setEnv('STRIPE_KEY', $request->stripe_key);
        setEnv('STRIPE_SECRET', $request->stripe_secret);
    }

    public function razorpaySetting($request)
    {
        setEnv('RAZORPAY_KEY', $request->razorpay_key);
        setEnv('RAZORPAY_SECRET', $request->razorpay_secret);
    }

    public function paystackSetting($request)
    {
        setEnv('PAYSTACK_PUBLIC_KEY', $request->paystack_key);
        setEnv('PAYSTACK_SECRET_KEY', $request->paystack_secret);
        setEnv('MERCHANT_EMAIL', $request->paystack_email);
    }

    protected function userBasicInfoUpdate($request, $user)
    {
        $user->update($request->only('name', 'email'));

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            deleteImage($user->image);
            $url = uploadFileToPublic($request->image, 'user');
            $user->update(['image' => $url]);
        }
    }

    public function adminProfileUpdate($request, $user)
    {
        $this->userBasicInfoUpdate($request, $user);
    }

    public function staffProfileUpdate($request, $user)
    {
        $this->userBasicInfoUpdate($request, $user);
        $user->staff->update($request->only('phone', 'religion', 'bio', 'present_address', 'permanent_address', 'gender'));
    }

    public function studentProfileUpdate($request, $user)
    {
        $this->userBasicInfoUpdate($request, $user);
        $user->student->update($request->only('date_of_birth', 'present_address', 'permanent_address', 'gender', 'blood_group'));
    }

    public function parentProfileUpdate($request, $user)
    {
        $this->userBasicInfoUpdate($request, $user);
        $user->guardian->update($request->only('phone', 'occupation', 'gender'));
    }

    protected function systemSetting($request) {
        $env = new Env;

        // class routine
        if ($request->time_diff && $request->time_diff != env('ROUTINE_TIME_DIFFERENCE')) {
            $env->setValue('ROUTINE_TIME_DIFFERENCE', $request->time_diff);
        }

        if ($request->start_time && $request->start_time != env('CLASS_START_TIME')) {
            $env->setValue('CLASS_START_TIME', $request->start_time);
        }

        if ($request->end_time && $request->end_time != env('CLASS_END_TIME')) {
            $env->setValue('CLASS_END_TIME', $request->end_time);
        }

        // db settings
        if ($request->db_connection && $request->db_connection != env('DB_CONNECTION')) {
            $env->setValue('DB_CONNECTION', $request->db_connection);
        }

        if ($request->db_host && $request->db_host != env('DB_HOST')) {
            $env->setValue('DB_HOST', $request->db_host);
        }

        if ($request->db_port && $request->db_port != env('DB_PORT')) {
            $env->setValue('DB_PORT', $request->db_port);
        }

        if ($request->db_name && $request->db_name != env('DB_DATABASE')) {
            $env->setValue('DB_DATABASE', $request->db_name);
        }

        if ($request->db_username && $request->db_username != env('DB_USERNAME')) {
            $env->setValue('DB_USERNAME', $request->db_username);
        }

        if ($request->db_password && $request->db_password != env('DB_PASSWORD')) {
            $env->setValue('DB_PASSWORD', $request->db_password);
        }

        // app settings
        if ($request->app_url && $request->app_url != env('APP_URL')) {
            $env->setValue('APP_URL', $request->app_url);
        }

        $env->setValue('APP_DEBUG', $request->app_debug ? 'true':'false');

        if ($request->timezone && $request->timezone != env('APP_TIMEZONE')) {
            $env->setValue('APP_TIMEZONE', $request->timezone);
        }

        if ($request->default_language && $request->default_language != env('DEFAULT_LANGUAGE')) {
            $env->setValue('APP_DEFAULT_LANGUAGE', $request->default_language);
        }

        if ($request->currency_sign && $request->currency_sign != env('APP_CURRENCY_SYMBOL')) {
            $env->setValue('APP_CURRENCY_SYMBOL', $request->currency_sign);
        }
    }
}
