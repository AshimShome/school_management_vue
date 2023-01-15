<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountantRequest extends FormRequest
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
            'email'      =>  ['required', 'email', 'unique:users,email,' . $this->accountant->user->id],
            'joining_date'    =>  ['required', 'date',],
            'gender'    =>  ['required', 'in:male,female',],
            'joining_letter'    =>  ['sometimes', 'nullable', 'mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png', 'max:2048'],
            'resume'    =>  ['sometimes', 'nullable', 'mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png', 'max:2048'],
        ];
    }
}
