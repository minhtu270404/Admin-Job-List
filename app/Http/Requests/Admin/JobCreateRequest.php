<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permission đã check ở middleware
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:255'],
            'company'       => ['required', 'exists:companies,id'],
            'category'      => ['required', 'exists:job_categories,id'],
            'vacancies'     => ['required', 'integer', 'min:1'],
            'deadline'      => ['required', 'date'],

            'country'       => ['required', 'exists:countries,id'],
            'state'         => ['required', 'exists:states,id'],
            'city'          => ['required', 'exists:cities,id'],
            'address'       => ['nullable', 'string', 'max:255'],

            'salary_mode'   => ['required', 'in:range,custom'],
            'min_salary'    => ['nullable', 'numeric', 'min:0'],
            'max_salary'    => ['nullable', 'numeric', 'gte:min_salary'],
            'custom_salary' => ['nullable', 'string', 'max:255'],
            'salary_type'   => ['required', 'exists:salary_types,id'],

            'experience'    => ['required', 'exists:experiences,id'],
            'job_role'      => ['required', 'exists:job_roles,id'],
            'education'     => ['required', 'exists:education,id'],
            'job_type'      => ['required', 'exists:job_types,id'],

            'featured'      => ['nullable', 'boolean'],
            'highlight'     => ['nullable', 'boolean'],
            'description'   => ['required', 'string'],

            'tags'          => ['nullable', 'array'],
            'tags.*'        => ['exists:tags,id'],

            'skills'        => ['nullable', 'array'],
            'skills.*'      => ['exists:skills,id'],

            'benefits'      => ['nullable', 'string'], // danh sách cách nhau bằng dấu phẩy
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề công việc là bắt buộc.',
            'company.required' => 'Vui lòng chọn công ty.',
            'category.required' => 'Vui lòng chọn danh mục việc làm.',
            'deadline.required' => 'Hạn nộp hồ sơ không được bỏ trống.',
            'salary_mode.required' => 'Chế độ lương là bắt buộc.',
            'salary_type.required' => 'Loại lương là bắt buộc.',
            'experience.required' => 'Kinh nghiệm là bắt buộc.',
            'education.required' => 'Trình độ học vấn là bắt buộc.',
            'description.required' => 'Vui lòng nhập mô tả công việc.',
        ];
    }
}
