<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',        // thêm name để tránh lỗi mass assignment
        'slug',        // khuyến khích thêm nếu bạn muốn update slug thủ công trong tương lai
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ],
        ];
    }
}
