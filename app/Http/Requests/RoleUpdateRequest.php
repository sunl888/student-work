<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
{
    protected $allowModifyFields = ['name', 'display_name', 'description', 'order'];

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
        $role = $this->route()->parameter('role');
        return [
            'name' => [Rule::unique('roles')->ignore($role->id)],
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
            'order' => 'nullable|int',
            'permission_ids' => 'nullable|int_array'
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
