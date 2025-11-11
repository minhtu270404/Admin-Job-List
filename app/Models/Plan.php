<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'price',
        'job_limit',
        'featured_job_limit',
        'highlight_job_limit',
        'profile_verified',
        'recommended',
        'frontend_show',
    ];
}
