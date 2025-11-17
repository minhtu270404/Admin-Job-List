<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobTag extends Model
{
    use HasFactory;

    // Thêm các trường được phép mass assignment
    protected $fillable = [
        'job_id',
        'tag_id',
    ];

    function tag(): BelongsTo {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}
