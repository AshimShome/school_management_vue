<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
            'email'      =>  ['required', 'email', 'unique:users,email,' . $this->teacher->user->id],
            'joining_date'    =>  ['required', 'date',],
            'department_id'    =>  ['required', 'exists:departments,id'],
            'gender'    =>  ['required', 'in:male,female,other',]
        ];
    }
}
