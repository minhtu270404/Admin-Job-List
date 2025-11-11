<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // middleware kiểm soát quyền
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên tỉnh / bang.',
            'name.string' => 'Tên tỉnh / bang phải là chuỗi ký tự.',
            'name.max' => 'Tên tỉnh / bang không được vượt quá 255 ký tự.',
            'country_id.required' => 'Vui lòng chọn quốc gia.',
            'country_id.exists' => 'Quốc gia chọn không hợp lệ.',
        ];
    }
}
