<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtistReview extends Model
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
        'artist_id',
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

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * Get the user that owns the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Assuming your User model is App\Models\User
    }
}