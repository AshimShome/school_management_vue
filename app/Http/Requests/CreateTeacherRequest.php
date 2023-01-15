<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeacherRequest extends FormRequest
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
            'name'      =>  ['required',],
            'email'      =>  ['required', 'email', 'unique:users,email'],
            'password'      =>  ['required'],
            'phone'      =>  ['required'],
            'joining_date'    =>  ['required', 'date'],
            'department_id'    =>  ['required', 'exists:departments,id'],
            'gender'    =>  ['required', 'in:male,female,other'],
            'joining_letter'    =>  ['sometimes', 'nullable', 'mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png', 'max:2048'],
            'resume'    =>  ['sometimes', 'nullable', 'mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png', 'max:2048'],
        ];
    }
}
