<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Albums extends Model
{
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artists::class);
    }
    public function songs(): HasMany
    {
        return $this->hasMany(Songs::class, 'genre_id'); 
    }
}
