<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

  
    protected function prepareForValidation(): void
    {
        $input = $this->all();

        foreach (['name', 'first_name', 'last_name', 'phone', 'link_social', 'dob'] as $k) {
            if ($this->has($k) && is_string($this->input($k))) {
                $input[$k] = trim($this->input($k));
            }
        }

        if (!empty($input['name'])) {
            $input['name'] = mb_strtolower($input['name']);
        }

        if (!empty($input['phone'])) {
            $digits = preg_replace('/\D+/', '', $input['phone']);
            if (preg_match('/^84\d{9}$/', $digits)) {
                $input['phone'] = '+'.$digits;
            }
            elseif (preg_match('/^0\d{9}$/', $digits)) {
                $input['phone'] = $digits;
            }
            elseif (preg_match('/^\d{9}$/', $digits)) {
                $input['phone'] = '0'.$digits;
            } else {

                $input['phone'] = $this->input('phone');
            }
        }

     
        if (!empty($input['link_social'])) {
            if (!preg_match('/^https?:\/\//i', $input['link_social'])) {
                $input['link_social'] = 'https://' . $input['link_social'];
            }
        }

        $this->merge($input);
    }

    public function rules(): array
    {
        $userId = Auth::id();

        $oldestDate = Carbon::now()->subYears(110)->toDateString();
        $youngestDate = Carbon::now()->subYears(13)->toDateString();

        return [
              'name' => [
                'required',
                'string',
                'min:4',
                'max:50',
                'not_regex:/^\d+$/',
                'regex:/^[\pL\pN][\pL\pN._-]{2,48}[\pL\pN]$/u',

                Rule::unique('s', 'name')->ignore($userId),
            ],

            'first_name' => ['nullable', 'string', 'max:30', 'regex:/^[\p{L}\p{M}\'\-\s\.]+$/u'],
            'last_name'  => ['nullable', 'string', 'max:30', 'regex:/^[\p{L}\p{M}\'\-\s\.]+$/u'],

            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^(0|\+84)\d{9}$/',
                Rule::unique('s', 'phone')->ignore($userId),
            ],

            'link_social' => ['nullable', 'string', 'url', 'max:255'],

            'avatar_url' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ],

            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],

            'dob' => [
                'nullable',
                'date',
                "after_or_equal:{$oldestDate}",
                "before_or_equal:{$youngestDate}",
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Vui lòng nhập tên người dùng.',
            'name.min'       => 'Tên người dùng phải có ít nhất 4 ký tự.',
            'name.max'       => 'Tên người dùng không được vượt quá 50 ký tự.',
            'name.unique'    => 'Tên người dùng này đã tồn tại.',
            'name.not_regex' => 'Tên người dùng không được chỉ là số.',
            'name.regex'     => 'Tên người dùng không hợp lệ. Chỉ chấp nhận chữ, số, ".", "_" hoặc "-" và không được bắt đầu/kết thúc bằng ký tự đặc biệt, hoặc lặp ký tự đặc biệt liên tiếp.',

            'first_name.max'     => 'Họ không được vượt quá 30 ký tự.',
            'first_name.regex'   => 'Họ chứa ký tự không hợp lệ.',
            'last_name.max'      => 'Tên không được vượt quá 30 ký tự.',
            'last_name.regex'    => 'Tên chứa ký tự không hợp lệ.',

            'phone.regex'        => 'Số điện thoại không hợp lệ. Định dạng mong đợi: 0xxxxxxxxx hoặc +84xxxxxxxxx (10 chữ số).',
            'phone.unique'       => 'Số điện thoại này đã được sử dụng bởi tài khoản khác.',
            'phone.max'          => 'Số điện thoại quá dài.',

            'link_social.url'    => 'Liên kết mạng xã hội phải là một URL hợp lệ (ví dụ: https://facebook.com/...).',
            'link_social.max'    => 'Liên kết mạng xã hội không được vượt quá 255 ký tự.',

            'avatar_url.image'   => 'Ảnh đại diện phải là một hình ảnh hợp lệ.',
            'avatar_url.mimes'   => 'Ảnh đại diện chỉ được phép có định dạng: jpg, jpeg, png, webp, gif.',
            'avatar_url.max'     => 'Ảnh đại diện không được vượt quá 2MB.',
            'avatar_url.dimensions' => 'Kích thước ảnh không hợp lệ. Yêu cầu tối thiểu 100x100 và tối đa 2000x2000.',

            'gender.in'          => 'Giới tính không hợp lệ. Chỉ chấp nhận: male, female, other.',

            'dob.date'           => 'Ngày sinh phải là một ngày hợp lệ.',
            'dob.after_or_equal' => 'Tuổi không được vượt quá 110 năm.',
            'dob.before_or_equal'=> 'Người dùng phải đủ 13 tuổi trở lên.',
        ];
    }


  
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $phone = $this->input('phone');
            if (!empty($phone)) {
                $phoneDigits = preg_replace('/\D+/', '', $phone);
                if ($phoneDigits) {
                    $rows = DB::table('s')
                        ->whereNotNull('phone')
                        ->where('id', '<>', Auth::id())
                        ->select('id', 'phone')
                        ->get();

                    foreach ($rows as $r) {
                        if ($r->phone) {
                            $p = preg_replace('/\D+/', '', $r->phone);
                            if ($p === $phoneDigits) {
                                $validator->errors()->add('phone', 'Số điện thoại này đã được đăng ký bởi tài khoản khác.');
                                break;
                            }
                        }
                    }
                }
            }

            $link = $this->input('link_social');
            if (!empty($link)) {
                $host = parse_url($link, PHP_URL_HOST) ?: '';
                $host = mb_strtolower($host);
                $host = preg_replace('/^www\./', '', $host);

                $allowed = [
                    'facebook.com', 'm.facebook.com', 'instagram.com', 'linkedin.com',
                    'twitter.com', 'tiktok.com', 'youtube.com', 'github.com',
                    't.me', 'telegram.me'
                ];

                $ok = false;
                foreach ($allowed as $domain) {
                    if ($host === $domain || str_ends_with($host, '.'.$domain)) {
                        $ok = true;
                        break;
                    }
                }

                if (!$ok) {
                    $validator->errors()->add('link_social', 'Chỉ chấp nhận đường dẫn tới các mạng xã hội phổ biến (facebook, instagram, linkedin, twitter, tiktok, youtube, github, telegram).');
                }
            }
        });
    }
}
