<?php

namespace App\Http\Requests\Admin\SocialIcon;

use Illuminate\Foundation\Http\FormRequest;

class SocialIconRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        // Nếu là store thì bắt buộc 'icon' + 'url'
        // Nếu là update thì 'icon' có thể bỏ trống (giống code gốc của bạn)
        if ($this->isMethod('post')) {
            return [
                'icon' => ['required', 'string', 'max:255'],
                'url'  => ['required', 'url'],
            ];
        }

        return [
            'icon' => ['nullable', 'string', 'max:255'],
            'url'  => ['required', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'icon.required' => 'Vui lòng chọn biểu tượng mạng xã hội.',
            'icon.string'   => 'Giá trị biểu tượng không hợp lệ.',
            'icon.max'      => 'Tên biểu tượng không được vượt quá 255 ký tự.',

            'url.required'  => 'Vui lòng nhập đường dẫn liên kết.',
            'url.url'       => 'Đường dẫn không hợp lệ, vui lòng nhập URL hợp lệ (vd: https://facebook.com).',
        ];
    }
}
