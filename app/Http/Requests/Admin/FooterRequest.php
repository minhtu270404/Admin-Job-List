<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FooterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'copyright' => ['nullable', 'string', 'max:255'],
            'details'   => ['nullable', 'string'],
            'logo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'logo.image' => 'Tệp tải lên phải là hình ảnh.',
            'logo.mimes' => 'Logo chỉ được định dạng: jpg, jpeg, png, svg, webp.',
            'logo.max'   => 'Logo không được vượt quá 2MB.',
        ];
    }
}
