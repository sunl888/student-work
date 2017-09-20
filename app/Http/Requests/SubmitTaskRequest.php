<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitTaskRequest extends FormRequest
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
            'assess_id' => 'bail|required|exists:assess,id', // 考核等级
            'status' => 'date',// 完成时间
            'quality' =>'nullable|max:255',// 完成质量
            'remark' => 'nullable|max:255',// 备注
            'delay' => 'nullable|max:255'// 推迟理由
        ];
    }

    public function messages()
    {
        return [
            'assess_id.required' =>'考核等级必须填写.',
            'assess_id.exists' =>'该等级不存在.',
            'quality.max' =>'完成质量最多255个字符.',
            'remark.max' =>'备注最多255个字符.',
            'delay.max' =>'推迟理由最多255个字符.',
            'status.date' =>'请填写正确的日期.'
        ];
    }
}
