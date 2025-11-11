<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép truy cập, hoặc thêm quyền
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            // Thêm các rules khác nếu cần
        ];
    }
}
