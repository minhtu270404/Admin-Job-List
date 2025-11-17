<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobSkills extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'skill_id'
    ];

    function skill() : BelongsTo {
        return $this->belongsTo(Skill::class, 'skill_id', 'id');
    }
}
