<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class RoleCreateRequest extends FormRequest
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
            'name' => 'required|alpha_dash|unique:roles',
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
            'permission_ids' => 'nullable|array'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '角色名必须填写',
            'name.alpha_dash' => '角色名必须是字母和数字或下划线',
            'name.unique' => '该角色已存在',
            'display_name.string' => '角色显示的名称必须是字符串',
            'permission_ids.string' => '角色显示的名称必须是字符串',
            'permission_ids.array' => '角色显示的名称必须是整形的数组',
        ];
    }
}
