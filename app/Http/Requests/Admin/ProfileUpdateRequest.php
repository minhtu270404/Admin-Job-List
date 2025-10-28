<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Cho phép tất cả admin đã đăng nhập thực hiện (có thể thêm policy sau)
        return auth()->guard('admin')->check();
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50'],
            'image' => ['nullable', 'image'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên hiển thị.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không hợp lệ.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
        ];
    }
}
