<?php

namespace App\Http\Controllers\Api\Admin;

use App\Traits\Settings;
use App\Mail\SendTestMail;
use msztorc\LaravelEnv\Env;
use App\Models\AdminSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SystemSettingFormRequest;
use App\Models\Timezone;
use Illuminate\Support\Facades\Mail;

class AdminSettingController extends Controller
{
    use Settings;

    /**
     * Get settings data.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchSetting()
    {
        $setting = AdminSetting::first();
        $setting['name'] = config('app.name');
        $setting['short_name'] = env('APP_SHORT_NAME');

        return responseSuccess('setting', $setting);
    }

    /**
     * Update admin setting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSetting(Request $request)
    {
        $env = new Env;
        $setting = AdminSetting::first();
        $setting['name'] = $request->name;
        $setting['email'] = $request->email;
        $setting['phone'] = $request->phone;
        $setting['address'] = $request->address;

        if ($request->has('name') && $request->name != config('app.name')) {
            $env->setValue('APP_NAME', $request->name);
        }

        if ($request->has('short_name') && $request->name != env('APP_SHORT_NAME')) {
            $env->setValue('APP_SHORT_NAME', $request->short_name);
        }

        if ($request->has('short_name') || $request->has('name')) \Artisan::call('config:clear');

        if ($request->hasFile('favicon') && $request->file('favicon')->isValid()) {
            $url = uploadFileToPublic($request->favicon, 'favicon');
            $setting->favicon = $url;
        }

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $url = uploadFileToPublic($request->logo, 'logo');
            $setting->logo = $url;
        }

        if ($request->hasFile('dark_logo') && $request->file('dark_logo')->isValid()) {
            $url = uploadFileToPublic($request->dark_logo, 'logo');
            $setting->dark_logo = $url;
        }

        $setting->save();

        return responseSuccess('setting', $setting, 'Setting Update Successfully');
    }

    /**
     * Get system setting Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSystemSettings()
    {
        $setting = [
            // app
            'app_debug' => env('APP_DEBUG'),
            'app_url' => env('APP_URL'),
            'default_language' => env('APP_DEFAULT_LANGUAGE'),
            'currency_sign' => env('APP_CURRENCY_SYMBOL'),
            'timezone' => env('APP_TIMEZONE'),

            // db
            'db_connection' => env('DB_CONNECTION'),
            'db_host' => env('DB_HOST'),
            'db_port' => env('DB_PORT'),
            'db_name' => env('DB_DATABASE'),
            'db_username' => env('DB_USERNAME'),
            'db_password' => env('DB_PASSWORD'),

            // class routine
            'time_diff' => config('app.calendar.time_difference'),
            'start_time' => config('app.calendar.start_time'),
            'end_time' => config('app.calendar.end_time'),
        ];

        return response()->json([
            'setting' => $setting,
            'timezones' => Timezone::all(['id', 'value']),
        ]);

        return responseSuccess('setting', $setting, 'Setting updated successfully');
    }

    /**
     * Update system setting Data.
     *
     * @param  SystemSettingFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSystemSettings(SystemSettingFormRequest $request)
    {
        $this->systemSetting($request);

        return responseSuccess('', '', 'Setting Updated Successfully');
    }

    /**
     * Get layout setting Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLayoutSettings()
    {
        $setting = AdminSetting::first();

        return responseSuccess('setting', $setting, 'Setting updated successfully');
    }

    /**
     * Update layout setting Data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateLayoutSettings(Request $request)
    {
        $this->validate($request, [
            'layout' => 'required',
            'nav_position' => 'required',
        ]);

        $setting = AdminSetting::first();

        if ($request->has('layout')) {
            $layoutArray = ['boxed', 'full-width'];
            $layout = $request->layout;

            if (!in_array($layout, $layoutArray)) {
                return responseError('Input data not valid for Layout', 422);
            }

            $setting->layout = $layout;
        }

        if ($request->has('nav_position')) {
            $navbarPositionArray = ['top', 'left', 'right'];
            $nav_position = $request->nav_position;

            if (!in_array($nav_position, $navbarPositionArray)) {
                return responseError('Input data not valid for Layout', 422);
            }

            $setting->nav_position = $nav_position;
        }

        $setting->sidebar_bg = $request->sidebar_bg;
        $setting->sidebar_text_color = $request->sidebar_text_color;
        $setting->navbar_bg = $request->navbar_bg;
        $setting->navbar_text_color = $request->navbar_text_color;
        $setting->save();

        return responseSuccess('setting', $setting, 'Setting updated successfully');
    }

    /**
     * Get mail setting Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPaymentSettings()
    {
        $paypal_key = env('PAYPAL_MODE') == 'sandbox' ? env('PAYPAL_SANDBOX_CLIENT_ID') : env('PAYPAL_LIVE_CLIENT_ID');
        $paypal_secret = env('PAYPAL_MODE') == 'sandbox' ? env('PAYPAL_SANDBOX_CLIENT_SECRET') : env('PAYPAL_LIVE_CLIENT_SECRET');

        return [
            'paypal_mode' => env('PAYPAL_MODE', 'sandbox'),
            'paypal_key' => $paypal_key,
            'paypal_secret' => $paypal_secret,
            'razorpay_key' => env('RAZORPAY_KEY'),
            'razorpay_secret' => env('RAZORPAY_SECRET'),
            'paystack_key' => env('PAYSTACK_PUBLIC_KEY'),
            'paystack_secret' => env('PAYSTACK_SECRET_KEY'),
            'paystack_email' => env('MERCHANT_EMAIL'),
            'stripe_key' => env('STRIPE_KEY'),
            'stripe_secret' => env('STRIPE_SECRET'),
        ];
    }

    /**
     * Update mail setting Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePaymentSettings(Request $request, $provider)
    {
        switch ($provider) {
            case 'paypal':
                $this->validate($request, [
                    'paypal_mode' => 'required',
                    'paypal_key' => 'required',
                    'paypal_secret' => 'required',
                ]);

                $this->paypalSetting($request);

                break;
            case 'stripe':
                $this->validate($request, [
                    'stripe_key' => 'required',
                    'stripe_secret' => 'required',
                ]);

                $this->stripeSetting($request);
                break;
            case 'razorpay':
                $this->validate($request, [
                    'razorpay_key' => 'required',
                    'razorpay_secret' => 'required',
                ]);

                $this->razorpaySetting($request);
                break;
            case 'paystack':
                $this->validate($request, [
                    'paystack_key' => 'required',
                    'paystack_secret' => 'required',
                    'paystack_email' => 'required',
                ]);

                $this->paystackSetting($request);
                break;
        }

        return responseSuccess('', '', 'Payment Setting Updated Successfully');
    }

    /**
     * Get mail setting Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMailSettings()
    {
        return [
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'from_name' => config('mail.from.name'),
            'from_address' => config('mail.from.address'),
            'username' => config('mail.mailers.smtp.username'),
            'password' => config('mail.mailers.smtp.password'),
        ];
    }

    /**
     * Update mail setting Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateMailSettings(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'port' => 'required',
            'encryption' => 'required',
            'from_name' => 'required',
            'from_address' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $env = new Env;

        if ($request->has('host') && $request->host != config('mail.mailers.smtp.host')) {
            setEnv('MAIL_HOST', $request->host);
        }

        if ($request->has('port') && $request->host != config('mail.mailers.smtp.port')) {
            setEnv('MAIL_PORT', $request->port);
        }

        if ($request->has('username') && $request->username != config('mail.mailers.smtp.username')) {
            setEnv('MAIL_USERNAME', $request->username);
        }

        if ($request->has('password') && $request->password != config('mail.mailers.smtp.password')) {
            setEnv('MAIL_PASSWORD', $request->password);
        }

        if ($request->has('encryption') && $request->encryption != config('mail.mailers.smtp.encryption')) {
            setEnv('MAIL_ENCRYPTION', $request->encryption);
        }

        if ($request->has('from_name') && $request->from_name != config('mail.from.name')) {
            $env->setValue('MAIL_FROM_NAME', $request->from_name);
        }

        if ($request->has('from_address') && $request->from_address != config('mail.from.address')) {
            setEnv('MAIL_FROM_ADDRESS', $request->from_address);
        }

        \Artisan::call('config:clear');

        return responseSuccess('', '', 'Setting Update Successfully');
    }

    /**
     * Send test mail.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendTestMail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        checkSetup() ? Mail::to($request->email)->send(new SendTestMail()) : '';

        return responseSuccess('', '', 'Test mail sent Successfully');
    }

    public function getRoutineTimeDifference()
    {
        return config('app.calendar.time_difference');
    }

    public function checkMailSetting()
    {
        if (env('MAIL_MAILER') && env('MAIL_HOST') && env('MAIL_PORT') && env('MAIL_USERNAME') && env('MAIL_PASSWORD') && env('MAIL_ENCRYPTION') && env('MAIL_FROM_ADDRESS') && env('MAIL_FROM_NAME')) {
            return true;
        }

        return false;
    }
}
