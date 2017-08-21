<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\Update;
use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $user = $this->route()->parameter('user');
        return [
            'name' => [Rule::unique('users')->ignore($user->id)],
            'email' => 'nullable|email',// email
            'college_id' => 'nullable|exists:colleges,id',// 学院id
            'picture' => 'nullable|image',// 头像
            'gender' => 'nullable|boolean', // 性别
            'role_id' => 'nullable|exists:roles,id', // 角色id
        ];
    }

    public function messages()
    {
        return [
            'name.unique' =>'用户名已存在',
            'college_id.exists' =>'该学院不存在',
            'picture.image' =>'头像格式不正确',
            'role_id.exists' =>'该角色不存在',
        ];
    }
}
