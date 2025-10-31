<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label' => ['required', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'job_limit' => ['required', 'integer', 'min:0'],
            'featured_job_limit' => ['required', 'integer', 'min:0'],
            'highlight_job_limit' => ['required', 'integer', 'min:0'],
            'profile_verified' => ['boolean'],
            'recommended' => ['boolean'],
            'frontend_show' => ['boolean'],
            'show_at_home' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'label.required' => 'Tên gói dịch vụ là bắt buộc.',
            'price.required' => 'Giá gói là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'job_limit.required' => 'Vui lòng nhập giới hạn số job.',
            'job_limit.integer' => 'Giới hạn job phải là số nguyên.',
        ];
    }
}
