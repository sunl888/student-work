<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeetingRequest extends FormRequest
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
            'title' => 'nullable|max:255',
            'detail' => 'nullable',
            'address' => 'nullable',
            'users' => 'nullable|users',
            'absent_cause' => 'array',
            'start_time' => 'nullable|date',
        ];
    }

    public function messages()
    {
        return [
            'users.users' => '指定的用户不存在',
            'start_time.date' => '请填写正确的日期格式.',
            'absent_cause.array' => 'absent_cause parameter must be an array'
        ];
    }
}
