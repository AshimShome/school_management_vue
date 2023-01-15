<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamMarkGetStudentRequest extends FormRequest
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
            'exam_id'        =>  ['required', 'exists:exams,id'],
            'class_id'        =>  ['required', 'exists:classses,id'],
            'section_id'        =>  ['required', 'exists:sections,id'],
            'subject_id'        =>  ['required', 'exists:subjects,id'],
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
            'session_id.required'   =>  'The session field is required.',
            'exam_id.required'      =>  'The exam field is required.',
            'class_id.required'     =>  'The class field is required.',
            'section_id.required'   =>  'The section field is required.',
            'subject_id.required'   =>  'The subject field is required.',
        ];
    }
}
