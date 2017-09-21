<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskScoreRequest extends FormRequest
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
            'college_id' => 'required|exists:colleges,id',
            'assess_id' => 'required|exists:assess,id',
            'quality' => 'required',
            'remark' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'college_id.required' => '学院必须要选择',
            'college_id.exists' => '该学院不存在',
            'assess_id.required' => '考核等级必须要选择',
            'assess_id.exists' => '选择的等级出现异常',
            'quality.required' => '完成的质量情况必须要填写',
            'remark.string' => '备注必须是字符串',
        ];
    }
}
