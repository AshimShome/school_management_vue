<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
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
                'name' => 'required|unique:classses,name',
                'numeric' => 'required|unique:classses,numeric|numeric|digits_between:1,2',
                'sections' => 'required'
            ];
        }else{
            return [
                'name' => "required|unique:classses,name,{$this->class->id}",
                'numeric' => "required|unique:classses,numeric,{$this->class->id}|numeric|digits_between:1,2",
                'sections' => 'required'
            ];
        }
    }
}
