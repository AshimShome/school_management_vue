<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeesRequest extends FormRequest
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
            'type_id' => 'required',
            'invoice_type' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'amount' => 'required|numeric',
            'due_date' => 'required',
            'status' => 'required',
        ];
    }
}
