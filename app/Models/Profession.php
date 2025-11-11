<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory, Sluggable;

    // Cho phép mass assignment cho các trường
    protected $fillable = [
        'name',   // bắt buộc nếu muốn create/update mass
        'slug',   // nếu muốn cập nhật slug qua mass assignment cũng được
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
