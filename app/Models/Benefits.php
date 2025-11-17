<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefits extends Model
{
    use HasFactory;

    // Các trường được phép mass assignment
    protected $fillable = [
        'company_id',
        'name',       // tên phúc lợi
        'description' // mô tả phúc lợi nếu có
    ];
}
