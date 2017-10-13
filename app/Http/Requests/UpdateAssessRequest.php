<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssessRequest extends FormRequest
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
            'title' => 'nullable|string',
            /*'type' => [
                'nullable',
                Rule::in(['examine', 'late']),
            ],*/// examine|late
            'score' => 'nullable|numeric|max:100',
        ];
    }

    public function messages()
    {
        return [
            //'title.required' =>'考核等级必须要填写',
            'title.string' => '考核等级必须是字符串',
            //'score.required' =>'该等级必须添加预制评分',
            'score.numeric' => '评分必须是数值型',
            'score.max' => '评分小于100'
        ];
    }
}
