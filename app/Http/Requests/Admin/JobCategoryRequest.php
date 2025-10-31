<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Nếu bạn đã dùng middleware permission rồi thì có thể return true
        // hoặc kiểm tra theo logic riêng như:
        // return $this->user()->can('job category create');
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('job_category'); // Tên parameter trong route, nếu khác thì đổi

        $rules = [
            'icon' => ['nullable', 'max:255'],
            'name' => ['required', 'max:255', 'unique:job_categories,name,' . $id],
            'show_at_popular' => ['nullable', 'boolean'],
            'show_at_featured' => ['nullable', 'boolean'],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
            'icon.required' => 'Icon là bắt buộc khi tạo mới.',
        ];
    }
}
