<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // cho phép mọi user được authorize, bạn có thể customize nếu cần
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'industry_type_id' => 'nullable|exists:industry_types,id',
            'organization_type_id' => 'nullable|exists:organization_types,id',
            'team_size_id' => 'nullable|exists:team_sizes,id',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'country' => 'nullable|exists:countries,id',
            'state' => 'nullable|exists:states,id',
            'city' => 'nullable|exists:cities,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'establishment_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'vision' => 'nullable|string',
            'map_link' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên công ty không được để trống',
            'user_id.required' => 'Người dùng không được để trống',
            'user_id.exists' => 'Người dùng không tồn tại',
            'website.url' => 'Địa chỉ website không hợp lệ',
            'email.email' => 'Email không hợp lệ',
            'country.exists' => 'Quốc gia không hợp lệ',
            'state.exists' => 'Tỉnh/Thành phố không hợp lệ',
            'city.exists' => 'Quận/Huyện không hợp lệ',
            'logo.image' => 'Logo phải là file ảnh',
            'banner.image' => 'Banner phải là file ảnh',
        ];
    }
}
