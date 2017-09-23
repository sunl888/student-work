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
            'user_id' => ['required', 'users'],  //user_id=all  |  1,2,3  |1
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => '请指定责任人',
            'user_id.users' => '用户id有误'
        ];
    }
}
