<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class IndustryTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->route('industry_type') ?? $this->route('id'); // hỗ trợ route model binding

        return [
            'name' => ['required', 'string', 'max:255', 'unique:industry_types,name,' . $id],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên ngành nghề là bắt buộc.',
            'name.max' => 'Tên ngành nghề không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên ngành nghề này đã tồn tại.',
        ];
    }
}
