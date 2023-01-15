<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SystemSettingFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // db
            'db_connection' => 'required',
            'db_host' => 'required',
            'db_port' => 'required',
            'db_name' => 'required',
            'db_username' => 'required',
            'db_password' => 'required',

            // app
            'app_debug' => 'required',
            'app_url' => 'required',
            'timezone' => 'required',
            'currency_sign' => 'required',

            // class routine
            'time_diff' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
    }
}
