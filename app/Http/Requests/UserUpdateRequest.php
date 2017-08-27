<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\Update;
use Dingo\Api\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        //$user = $this->route()->parameter('user');
        return [
            //'name' => [Rule::unique('users')->ignore($user->id)],
            'email' => 'nullable|email',// email
            //'college_id' => 'nullable',// 学院id
            'picture' => 'nullable',// 头像
            'gender' => 'nullable|boolean', // 性别
            'password' => 'nullable|confirmed',// 密码
            //'role_id' => 'nullable', // 角色id
        ];
    }

    public function messages()
    {
        return [
            //'name.unique' =>'用户名已存在',
            //'role_id.exists' =>'该角色不存在',
            'password.confirmed' => '两次密码不一致',
        ];
    }
}
