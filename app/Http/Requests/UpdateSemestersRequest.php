<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSemestersRequest extends FormRequest
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
            'title' => 'nullable',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date',
            'checked' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            '*.date' => '请填写正确的日期'
        ];
    }
}
