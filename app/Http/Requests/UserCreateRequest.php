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
            'name' => 'bail|required|unique:users,name',// 用户名
            'nickname' => 'required',// 用户名
            'email' => 'bail|required|email',// email
            'college_id' => 'bail|nullable|exists:colleges,id',// 学院id
            'picture' => 'bail|nullable',// 头像
            'phone' => ['bail', 'nullable', 'regex:/^1[34578][0-9]{9}$/'],
            'password' => ['bail','required','confirmed','between:6,16','regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z_]{6,16}$/'],// 密码
            'role_id' => 'bail|required|exists:roles,id', // 角色id
            'gender' => 'bail|required|boolean', // 性别
        ];
    }

    public function messages()
    {
        return [
            'required' => ' :attribute 字段必须填写.',
            'email' => ':attribute 格式不正确',
            'unique' => ':attribute 已存在',
            'college_id.exists' => '该学院不存在',
            'gender.boolean' => ':gender 必须是bool型(true:女 false:男)',
            'confirmed' => '两次 :attribute 不一致',// 注意传password_confirmation字段
            'between' => ':attribute 的必须长度在 :min - :max 位之间.',
            'alpha_num' => ':attribute 必须是字母或数字',
            'regex' => ':attribute 格式不正确',
            'role_id.exists' => '该角色不存在',
        ];
    }
}
