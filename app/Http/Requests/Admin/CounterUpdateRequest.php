<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CounterUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'counter_one'   => ['required', 'numeric'],
            'title_one'     => ['required', 'string', 'max:255'],
            'counter_two'   => ['required', 'numeric'],
            'title_two'     => ['required', 'string', 'max:255'],
            'counter_three' => ['required', 'numeric'],
            'title_three'   => ['required', 'string', 'max:255'],
            'counter_four'  => ['required', 'numeric'],
            'title_four'    => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được bỏ trống.',
            'numeric'  => ':attribute phải là số.',
            'max'      => ':attribute vượt quá độ dài cho phép.',
        ];
    }

    public function attributes(): array
    {
        return [
            'counter_one'   => 'Giá trị bộ đếm 1',
            'title_one'     => 'Tiêu đề 1',
            'counter_two'   => 'Giá trị bộ đếm 2',
            'title_two'     => 'Tiêu đề 2',
            'counter_three' => 'Giá trị bộ đếm 3',
            'title_three'   => 'Tiêu đề 3',
            'counter_four'  => 'Giá trị bộ đếm 4',
            'title_four'    => 'Tiêu đề 4',
        ];
    }
}
