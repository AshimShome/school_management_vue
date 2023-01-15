<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoutineRequest extends FormRequest
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
        if ($this->method() === 'POST') {
            return [
                'class_id'              =>  ['required', 'exists:classses,id'],
                'section_id'            =>  ['required', 'exists:sections,id'],
                'class_room_id'         =>  ['required', 'exists:class_rooms,id'],
                'teacher_id'            =>  ['required', 'exists:staff,id'],
                'subject_id'            =>  ['required', 'exists:subjects,id'],
                'weekday'                   =>  ['required', 'in:1,2,3,4,5,6,7'],
                'start_time'            =>  ['required', 'date_format:H:i'],
                'end_time'              =>  ['required', 'date_format:H:i'],
            ];
        } else {
            return [
                'class_id'              =>  ['required', 'exists:classses,id'],
                'section_id'            =>  ['required', 'exists:sections,id'],
                'class_room_id'         =>  ['required', 'exists:class_rooms,id'],
                'teacher_id'            =>  ['required', 'exists:staff,id'],
                'subject_id'            =>  ['required', 'exists:subjects,id'],
                'weekday'                   =>  ['required', 'in:1,2,3,4,5,6,7'],
                'start_time'            =>  ['required',],
                'end_time'              =>  ['required',],
            ];
        }
    }
}
