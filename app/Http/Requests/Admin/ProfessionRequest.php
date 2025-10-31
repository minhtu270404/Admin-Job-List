<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfessionRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('profession');
        return [
            'name' => ['required', 'max:255', 'unique:professions,name,' . $id],
        ];
    }
}
