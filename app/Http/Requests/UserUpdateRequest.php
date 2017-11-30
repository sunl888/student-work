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
            'nickname' => 'nullable',
            'email' => 'nullable|email',// email
            'college_id' => 'nullable',// 学院id
            'picture' => 'nullable',// 头像
            'gender' => 'nullable|boolean', // 性别
            'password' => 'bail|nullable|confirmed|min:5|max:20|alpha_num|regex:/^(?!([A-Za-z]+|d\d+)$)[A-Za-z\d]$/',// 密码
            'role_id' => 'nullable', // 角色id
        ];
    }

    public function messages()
    {
        return [
            //'name.unique' =>'用户名已存在',
            //'role_id.exists' =>'该角色不存在',
            'password.confirmed' => '两次密码不一致',
            'password.min' =>'密码最少5位',
            'password.max' =>'密码最多20位',
            'password.alpha_num' =>'密码必须是字母或数字',
            'password.regex' =>'密码必须是字母和数字的组合',
        ];
    }
}
