<?php

namespace App\Http\Requests\Admin\Skill;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id'); // lấy id từ route cho update

        return [
            'name' => ['required', 'max:255', 'unique:skills,name,' . $id],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên kỹ năng không được để trống.',
            'name.max'      => 'Tên kỹ năng không được vượt quá 255 ký tự.',
            'name.unique'   => 'Tên kỹ năng đã tồn tại.',
        ];
    }
}
