<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterSendRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject' => ['required', 'max:255'],
            'message' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'Vui lòng nhập tiêu đề email.',
            'subject.max' => 'Tiêu đề email không được vượt quá 255 ký tự.',
            'message.required' => 'Vui lòng nhập nội dung email.',
        ];
    }
}
