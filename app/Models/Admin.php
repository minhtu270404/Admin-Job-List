<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $table = 'admins';

    protected $fillable = [
        // Thông tin đăng nhập
        'name',
        'email',
        'phone',
        'password',

        // Thông tin bảo mật
        'email_verified_at',
        'phone_verified_at',
        'last_login_ip',
        'last_login_at',
        'two_factor_enabled',
        'two_factor_secret',
        'failed_login_attempts',
        'last_failed_login_at',

        // Thông tin cá nhân
        'first_name',
        'last_name',
        'full_name',
        'dob',
        'gender',
        'address_line',
        'link_social',
        'city',
        'state',
        'postal_code',
        'country_code',
        'timezone',
        'language',
        'avatar_url',
        'cover_image_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'last_failed_login_at' => 'datetime',
        'dob' => 'date',
        'two_factor_enabled' => 'boolean',
    ];

    /**
     * Khi set first_name hoặc last_name → tự động tạo full_name
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($admin) {
            $admin->full_name = trim("{$admin->first_name} {$admin->last_name}");
        });
    }

    /**
     * Accessor: Lấy URL avatar (nếu lưu trong storage)
     */
    public function getAvatarUrlAttribute($value)
    {
        if (!$value) {
            return asset('default-uploads/avatar.png');
        }

        // Nếu là link tuyệt đối (http/https)
        if (preg_match('/^https?:\/\//', $value)) {
            return $value;
        }

        // Nếu là path tương đối => trả về URL đầy đủ
        return Storage::url($value);
    }

    /**
     * Accessor: Lấy giới tính hiển thị tiếng Việt
     */
    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'male' => 'Nam',
            'female' => 'Nữ',
            'other' => 'Khác',
            default => 'Không xác định',
        };
    }

    /**
     * Scope: tìm theo email hoặc username hoặc phone
     */
    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%")
              ->orWhere('phone', 'like', "%{$keyword}%")
              ->orWhere('full_name', 'like', "%{$keyword}%");
        });
    }

    /**
     * Helper: kiểm tra có bật 2FA hay chưa
     */
    public function hasTwoFactorEnabled(): bool
    {
        return $this->two_factor_enabled && !empty($this->two_factor_secret);
    }
}
