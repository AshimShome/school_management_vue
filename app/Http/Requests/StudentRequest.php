<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        if ($this->method() == 'POST') {
            return [
                'name'      =>  ['required',],
                'email'      =>  ['required', 'email', 'unique:users,email'],
                'password'      =>  ['required'],
                'admission_date'    =>  ['date'],
                'class_id'    =>  ['required'],
                'section_id'    =>  ['required'],
                'roll_no'    =>  ['required', 'numeric'],
                'parent_id'    =>  ['required'],
            ];
        } else {
            return [
                'name'      =>  ['required',],
                'email'      =>  ['required', 'email', 'unique:users,email,' . $this->student->user->id],
                'admission_date'    =>  ['date'],
                'class_id'    =>  ['required'],
                'section_id'    =>  ['required'],
                'roll_no'    =>  ['required', 'numeric'],
                'parent_id'    =>  ['required']
            ];
        }
    }
}
