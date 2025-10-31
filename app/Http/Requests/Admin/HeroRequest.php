<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HeroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:3072'],
            'background_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:3072'],
            'title'             => ['required', 'string', 'max:255'],
            'sub_title'         => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'sub_title.required' => 'Phụ đề là bắt buộc.',
            'sub_title.max' => 'Phụ đề không được vượt quá 255 ký tự.',
            'image.image' => 'Ảnh chính phải là tệp hình ảnh.',
            'background_image.image' => 'Ảnh nền phải là tệp hình ảnh.',
            'image.max' => 'Ảnh chính không được vượt quá 3MB.',
            'background_image.max' => 'Ảnh nền không được vượt quá 3MB.',
        ];
    }
}
