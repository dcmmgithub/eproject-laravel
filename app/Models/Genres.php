<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genres extends Model
{
    public function songs(): HasMany
    {
        return $this->hasMany(Songs::class, 'genre_id'); 
    }
}
