<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|unique:users,name',// 用户名
            'email' => 'required|email',// email
            'college_id' => 'nullable|exists:colleges,id',// 学院id
            'picture' => 'nullable',// 头像
            'gender' => 'required|boolean', // 性别
            'password' => 'required|confirmed',// 密码
            'role_id' => 'required|exists:roles,id', // 角色id
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'用户名必须填写',
            'name.unique' =>'用户名已存在',
            'email.required' =>'email必须填写',
            'college_id.exists' =>'该学院不存在',
            //'picture.image' =>'头像格式不正确',
            'gender.required' =>'性别必须选择',
            'gender.boolean' =>'性别必须是bool型(true:女 false:男)',
            'password.required' =>'密码必须填写',
            'password.confirmed' =>'两次密码不一致(注意传password_confirmation字段)',
            'role_id.required' =>'角色必须选择',
            'role_id.exists' =>'该角色不存在',
        ];
    }
}
