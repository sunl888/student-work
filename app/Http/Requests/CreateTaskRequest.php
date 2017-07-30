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
            'title'=>'required',
            'detail'=>'required',
            'work_type_id'=>'required',
            'department_id'=>'required',
            'end_time'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' =>'标题必须要填写',
            'detail.required' =>'任务详情必须要填写',
            'work_type_id.required' =>'工作类型必须要填写',
            'department_id.required' =>'请选择对口科室',
            'end_time.required' =>'结束时间必须要填写',
        ];
    }
}
