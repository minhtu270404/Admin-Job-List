<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationType extends Model
{
    use HasFactory, Sluggable;

    // Cho phép gán mass assignment cho các trường này
    protected $fillable = [
        'name',  // bắt buộc có nếu muốn tạo/update mass
        'slug',  // nếu bạn muốn mass update slug cũng ok
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'organization_type_id', 'id');
    }
}
