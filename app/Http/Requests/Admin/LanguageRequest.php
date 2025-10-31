<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('language'); // Lấy id khi update
        return [
            'name' => ['required', 'max:255', 'unique:languages,name,' . $id],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên ngôn ngữ.',
            'name.max'      => 'Tên ngôn ngữ không được vượt quá 255 ký tự.',
            'name.unique'   => 'Ngôn ngữ này đã tồn tại trong hệ thống.',
        ];
    }
}
