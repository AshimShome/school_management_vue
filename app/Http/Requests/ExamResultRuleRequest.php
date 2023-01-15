<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamResultRuleRequest extends FormRequest
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
            'name'          =>  ['required','max:10'],
            'gpa'           =>  ['required','numeric'],
            'min_mark'      =>  ['required', 'numeric'],
            'max_mark'      =>  ['required', 'numeric',],
            'note'          =>  ['nullable'],
        ];
    }
}
