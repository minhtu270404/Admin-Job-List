<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GetStatesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => ['required', 'uuid', 'exists:countries,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'country_id.required' => 'Thiếu mã quốc gia.',
            'country_id.uuid' => 'Định dạng country_id không hợp lệ.',
            'country_id.exists' => 'Quốc gia không tồn tại trong hệ thống.',
        ];
    }
}
