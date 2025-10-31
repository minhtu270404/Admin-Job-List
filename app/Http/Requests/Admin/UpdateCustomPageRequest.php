<?php

namespace App\Http\Requests\Admin\CustomPageBuilder;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('site pages');
    }

    public function rules(): array
    {
        return [
            'page_name' => ['required', 'string', 'max:255'],
            'content'   => ['required', 'string'],
        ];
    }
}
