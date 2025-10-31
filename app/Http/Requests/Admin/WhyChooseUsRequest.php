<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WhyChooseUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'icon_one' => ['nullable', 'string', 'max:255'],
            'title_one' => ['nullable', 'string', 'max:255'],
            'sub_title_one' => ['nullable', 'string', 'max:255'],
            'icon_two' => ['nullable', 'string', 'max:255'],
            'title_two' => ['nullable', 'string', 'max:255'],
            'sub_title_two' => ['nullable', 'string', 'max:255'],
            'icon_three' => ['nullable', 'string', 'max:255'],
            'title_three' => ['nullable', 'string', 'max:255'],
            'sub_title_three' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            '*.max' => 'Trường này không được vượt quá 255 ký tự.',
        ];
    }
}
