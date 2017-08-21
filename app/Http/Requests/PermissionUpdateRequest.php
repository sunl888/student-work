<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionUpdateRequest extends FormRequest
{
    protected $allowModifyFields = ['name', 'display_name', 'description'];

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
        $permission = $this->route()->parameter('permission');
        return [
            'name' => [Rule::unique('permissions')->ignore($permission->id)],
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
