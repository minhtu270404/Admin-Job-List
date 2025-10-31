<?php

namespace App\Http\Requests\Admin\State;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'country' => ['required', 'integer', 'exists:countries,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên tỉnh/thành phố.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'country.required' => 'Vui lòng chọn quốc gia.',
            'country.integer' => 'Giá trị quốc gia không hợp lệ.',
            'country.exists' => 'Quốc gia được chọn không tồn tại trong hệ thống.',
        ];
    }
}
