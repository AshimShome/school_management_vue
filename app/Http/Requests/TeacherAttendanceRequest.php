<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherAttendanceRequest extends FormRequest
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
            "teacher_data"  =>  ['required', 'array'],
            'teacher_data.*.teacher_id'        =>  ['required', 'exists:staff,id'],
            'teacher_data.*.status'            =>  ['required', 'boolean'],
            'teacher_data.*.date'   =>  ['required', 'date'],
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'teacher_data.*.status.required'            =>  'The status field is required.',
            'teacher_data.*.date.required'   =>  'The date field is required.',
            'teacher_data.*.date.date'       =>  'The date field must be a valid date.',
        ];
    }
}
