<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobTypeUpdateRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id'); // Lấy id từ route
        return [
            'name' => ['required', 'max:255', 'unique:job_types,name,' . $id],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên loại công việc.',
            'name.max'      => 'Tên loại công việc không được vượt quá 255 ký tự.',
            'name.unique'   => 'Tên loại công việc đã tồn tại.',
        ];
    }
}
