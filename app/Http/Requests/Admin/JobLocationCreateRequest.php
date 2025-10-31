<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobLocationCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // đã có middleware permission nên true
    }

    public function rules(): array
    {
        return [
            'country' => 'required|exists:countries,id',
            'status'  => 'required|in:active,inactive',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'country.required' => 'Vui lòng chọn quốc gia.',
            'country.exists'   => 'Quốc gia không hợp lệ.',
            'status.required'  => 'Vui lòng chọn trạng thái.',
            'status.in'        => 'Trạng thái không hợp lệ.',
            'image.image'      => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes'      => 'Định dạng ảnh hợp lệ: jpeg, png, jpg, webp.',
            'image.max'        => 'Kích thước ảnh tối đa là 2MB.',
        ];
    }
}
