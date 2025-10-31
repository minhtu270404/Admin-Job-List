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
            'country' => ['required', 'integer', 'exists:countries,id'],
            'state' => ['required', 'integer', 'exists:states,id'],
            'city' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'country.required' => 'Vui lòng chọn quốc gia.',
            'country.exists' => 'Quốc gia không tồn tại.',
            'state.required' => 'Vui lòng chọn tiểu bang/tỉnh.',
            'state.exists' => 'Tiểu bang/tỉnh không tồn tại.',
            'city.required' => 'Vui lòng nhập tên thành phố.',
            'city.max' => 'Tên thành phố không được vượt quá 255 ký tự.',
        ];
    }
}
