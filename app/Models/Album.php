<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }
    public function songs(): HasMany
    {
        return $this->hasMany(Songs::class, 'genre_id'); 
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(AlbumReview::class);
    }
}
