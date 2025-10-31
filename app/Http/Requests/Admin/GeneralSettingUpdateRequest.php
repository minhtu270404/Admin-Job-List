<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // đã có middleware permission
    }

    public function rules(): array
    {
        return [
            'site_name' => ['required', 'max:255'],
            'site_email' => ['nullable', 'email', 'max:255'],
            'site_phone' => ['nullable', 'max:20'],
            'site_address' => ['nullable', 'max:255'],
            'site_description' => ['nullable', 'max:500'],
            'site_keywords' => ['nullable', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'site_name.required' => 'Vui lòng nhập tên website.',
            'site_name.max' => 'Tên website không được vượt quá 255 ký tự.',
            'site_email.email' => 'Địa chỉ email không hợp lệ.',
            'site_email.max' => 'Email không được vượt quá 255 ký tự.',
            'site_phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'site_address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'site_description.max' => 'Mô tả không được vượt quá 500 ký tự.',
            'site_keywords.max' => 'Từ khóa không được vượt quá 255 ký tự.',
        ];
    }
}
