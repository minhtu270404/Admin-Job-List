<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Thêm fillable để cho phép mass assignment
    protected $fillable = [
        'image',
        'name',
        'title',
        'review',
        'rating',
    ];
}
