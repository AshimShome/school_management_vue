<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
                'joining_date'    =>  ['required', 'date',],
                'designation'    =>  ['required',],
                'department_id'    =>  ['required', 'exists:departments,id'],
                'gender'    =>  ['required', 'in:male,female,other',],
                'religion'    =>  ['nullable', 'in:muslim,hindu,christian,buddha',],
                'joining_letter'    =>  ['sometimes', 'nullable', 'mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png', 'max:2048'],
                'resume'    =>  ['sometimes', 'nullable', 'mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png', 'max:2048'],
                'other_document'    =>  ['sometimes', 'nullable', 'mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png', 'max:2048'],
            ];
        } else {
            return [
                'name'      =>  ['required',],
                'email'      =>  ['required', 'email', 'unique:users,email,' . $this->staff->user->id],
                'joining_date'    =>  ['required', 'date',],
                'designation'    =>  ['required',],
                'department_id'    =>  ['required', 'exists:departments,id'],
                'gender'    =>  ['required', 'in:male,female,other',],
                'religion'    =>  ['nullable', 'in:muslim,hindu,christian,buddha',],
                'joining_letter'    =>  ['sometimes', 'nullable', 'mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png', 'max:2048'],
                'resume'    =>  ['sometimes', 'nullable', 'mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png', 'max:2048'],
                'other_document'    =>  ['sometimes', 'nullable', 'mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png', 'max:2048'],
            ];
        }
    }
}
