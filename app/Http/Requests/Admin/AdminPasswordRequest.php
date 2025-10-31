<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Chỉ cho phép user đã đăng nhập đổi mật khẩu
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Mật khẩu hiện tại không chính xác.');
                    }
                }
            ],
            'new_password' => 'required|string|min:6|max:32|confirmed|different:old_password',
        ];
    }

    public function messages(): array
    {
        return [
            // Mật khẩu hiện tại
            'old_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',

            // Mật khẩu mới
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.string' => 'Mật khẩu mới phải là một chuỗi ký tự hợp lệ.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất :min ký tự.',
            'new_password.max' => 'Mật khẩu mới không được vượt quá :max ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'new_password.different' => 'Mật khẩu mới phải khác mật khẩu hiện tại.',
        ];
    }
}
