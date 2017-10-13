<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => 'required',
            'type' => [
                'required',
                Rule::in(['examine', 'late']),
            ],  // examine|late
            'score' => 'required|numeric|max:100',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '考核等级必须要填写',
            'score.required' => '该等级必须添加预制评分',
            'type.required' => '类型必须填写',
            'score.numeric' => '评分必须是数值型',
            'score.max' => '评分小于100'
        ];
    }
}
