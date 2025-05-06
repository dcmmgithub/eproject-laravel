<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Songs extends Model
{
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genres::class);
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(Languages::class);
    }
}
