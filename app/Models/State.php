<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
{
    use HasFactory;

    // Chỉ những field có thể mass assign
    protected $fillable = ['name', 'country_id'];

    // Quan hệ với Country
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
