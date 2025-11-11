<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LearnMoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Hoặc kiểm tra quyền
    }

    public function rules(): array
    {
        return [
            'image' => ['nullable', 'image', 'max:3000'], // max 3MB
            'title' => ['required', 'max:255'],
            'main_title' => ['required', 'max:255'],
            'sub_title' => ['required', 'max:255'],
            'url' => ['nullable', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.max' => 'Hình ảnh không được vượt quá 3MB.',
            'title.required' => 'Vui lòng nhập tiêu đề nhỏ.',
            'main_title.required' => 'Vui lòng nhập tiêu đề chính.',
            'sub_title.required' => 'Vui lòng nhập tiêu đề phụ.',
            'url.url' => 'Đường dẫn không hợp lệ.',
        ];
    }
}
