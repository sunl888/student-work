<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSemestersRequest extends FormRequest
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
            'title' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'parent_id' => 'exists:semesters,id',
            'checked' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => ':attribute 必须要填写',
            'parent_id.exists' => '该学年不存在.',
            'checked.boolean' => '类型不匹配.'
        ];
    }
}
