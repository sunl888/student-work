<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllotTaskRequest extends FormRequest
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
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|alpha_num',
        ];
    }

    public function messages()
    {
        return [
            'task_id.required' => '任务ID有误',
            'task_id.exists' => '该任务不存在',
            'user_id.required' => '必须指定一名责任人',
            'user_id.alpha_num' => '请指定责任人(all || id)'
        ];
    }
}
