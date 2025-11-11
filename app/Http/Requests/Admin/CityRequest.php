<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'state_id' => ['required', 'integer', 'exists:states,id'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên thành phố.',
            'name.max' => 'Tên thành phố không được vượt quá 255 ký tự.',
            'state_id.required' => 'Vui lòng chọn tỉnh / bang.',
            'state_id.exists' => 'Tỉnh / bang không tồn tại.',
            'country_id.required' => 'Vui lòng chọn quốc gia.',
            'country_id.exists' => 'Quốc gia không tồn tại.',
        ];
    }
}
