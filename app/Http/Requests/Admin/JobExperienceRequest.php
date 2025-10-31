<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobExperienceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // có thể thêm policy sau
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
