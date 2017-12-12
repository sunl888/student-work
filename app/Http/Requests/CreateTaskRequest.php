<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            'detail' => 'required',
            'work_type_id' => 'required|exists:work_types,id',
            'department_id' => 'required|exists:departments,id',
            'end_time' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题必须要填写',
            'detail.required' => '任务详情必须要填写',
            'work_type_id.required' => '工作类型必须要填写',
            'work_type_id.exists' => '工作类型不存在',
            'department_id.required' => '请选择对口科室',
            'department_id.exists' => '对口科室不存在',
            'end_time.required' => '结束时间必须要填写',
            'end_time.date' => '请填写正确的日期格式',
        ];
    }
}
