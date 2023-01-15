<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
                'gender'    =>  ['required', 'in:male,female,other',],
                'religion'    =>  ['nullable', 'in:muslim,hindu,christian,buddha',],
            ];
        } else {
            return [
                'name'      =>  ['required',],
                'email'      =>  ['required', 'email', 'unique:users,email,' . $this->teacher->user->id],
                'joining_date'    =>  ['required', 'date',],
                'designation'    =>  ['required',],
                'gender'    =>  ['required', 'in:male,female,other',],
                'religion'    =>  ['nullable', 'in:muslim,hindu,christian,buddha',],
            ];
        }
    }
}
