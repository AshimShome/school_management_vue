<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'class_id' => ['required',],
            'name' => ['required'],
            'code' => ['required','max:10'],
            'type' => ['required','in:theory,practical'],
            'is_optional' => ['required'],
            'total_marks' => ['required','numeric','max:100','min:1'],
            'pass_marks' => ['required','numeric','max:100','min:1']
        ];
    }
}
