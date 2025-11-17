<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobBenefits extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'benefit_id'
    ];

    function benefit() : BelongsTo {
        return $this->belongsTo(Benefits::class, 'benefit_id', 'id');
    }
}
