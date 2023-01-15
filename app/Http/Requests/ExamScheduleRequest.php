<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamScheduleRequest extends FormRequest
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
            'exam_id'      =>  ['required', 'exists:exams,id'],
            'room_id'      =>  ['required', 'exists:class_rooms,id'],
            'class_id'      =>  ['required', 'exists:classses,id'],
            'subject_id'      =>  ['required', 'exists:subjects,id'],
            'section_id'      =>  ['required', 'exists:sections,id'],
            'start_time'      =>  ['required',],
            'end_time'      =>  ['required',],
        ];
    }
}
