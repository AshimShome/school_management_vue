<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentAttendanceSaveRequest extends FormRequest
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
            "student_data" =>  ['required', 'array'],
            'student_data.*.student_id' => ['required', 'exists:students,id'],
            'student_data.*.class_id' => ['required', 'exists:classses,id'],
            'student_data.*.section_id' => ['required', 'exists:sections,id'],
            'student_data.*.status' => ['required', 'boolean'],
            'student_data.*.date' => ['required', 'date'],
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
            'student_data.*.status.required' =>  'The status field is required.',
            'student_data.*.date.required'   =>  'The date field is required.',
            'student_data.*.date.date'       =>  'The date field must be a valid date.',
        ];
    }
}
