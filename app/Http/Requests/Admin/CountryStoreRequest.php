<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CountryStoreRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:countries,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên quốc gia không được bỏ trống.',
            'name.unique'   => 'Tên quốc gia đã tồn tại.',
            'name.max'      => 'Tên quốc gia quá dài.',
        ];
    }
}
