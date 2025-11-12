<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'banner',
        'bio',
        'vision',
        'industry_type_id',
        'organization_type_id',
        'team_size_id',
        'establishment_date',
        'website',
        'email',
        'phone',
        'country',
        'state',
        'city',
        'address',
        'map_link',
        'is_profile_verified',
        'document_verified_at',
        'profile_completion',
        'visibility',
        'total_views',
    ];
    protected $casts = [
        'establishment_date' => 'date',
    ];
    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /** RELATIONSHIPS **/

    // Người dùng sở hữu công ty
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Loại ngành nghề
    public function industryType(): BelongsTo
    {
        return $this->belongsTo(IndustryType::class);
    }

    // Loại tổ chức
    public function organizationType(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }

    // Quy mô đội ngũ
    public function teamSize(): BelongsTo
    {
        return $this->belongsTo(TeamSize::class);
    }

    // Quốc gia
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }

    // Tỉnh/Thành phố
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }

    // Thành phố/Quận/Huyện
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }

    // Gói dịch vụ của người dùng cho công ty này
    public function userPlan(): HasOne
    {
        return $this->hasOne(UserPlan::class, 'company_id', 'id');
    }

    // Các công việc (job) của công ty
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'company_id', 'id');
    }
}
