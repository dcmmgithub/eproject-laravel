<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlbumReview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'comment',
        'rating',
        'album_id',
        'user_id',
        'date'
    ];

    /**
     * The attributes that should be cast.
     * Allows automatic conversion (e.g., string from JSON to Carbon date object)
     * @var array
     */
    protected $casts = [
        'rating' => 'integer',
        'date' => 'date', // Use 'datetime' if you used dateTime in migration
    ];

    /**
     * Get the album that owns the review.
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class); // Assuming your Album model is App\Models\Album
    }

    /**
     * Get the user that owns the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Assuming your User model is App\Models\User
    }
}