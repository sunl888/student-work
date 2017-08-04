<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAssessRequest extends FormRequest
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
            'title' =>'required',
            'score' =>'required|numeric|between:1,100',
        ];
    }

    public function messages(){
        return [
            'title.required' =>'考核等级必须要填写',
            'score.required' =>'该等级必须添加预制评分',
            'score.numeric' =>'评分必须是数值型',
            'score.between' =>'评分范围是1~100之间'
        ];
    }
}
