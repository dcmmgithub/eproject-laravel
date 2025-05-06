<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model
{
    public function songs(): HasMany // Or BelongsToMany if through albums
    {
        // If artist is directly on songs table:
        return $this->hasMany(Songs::class, 'artist_id');

        // If songs are linked via albums (more complex, might need a custom query or a package):
        // This example gets songs through the artist's albums.
        // return $this->hasManyThrough(Songs::class, Album::class);
        // For a more direct "top songs" you might query differently, e.g., by play count if you track that.
        // For now, let's assume a direct `HasMany` or we'll just pull some songs from their albums.
    }
    public function albums(): HasMany // <-- DEFINE THIS METHOD
    {
        // Assuming your 'albums' table has an 'artist_id' column
        // and your Album model is App\Models\Album
        return $this->hasMany(Album::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(ArtistReview::class);
    }
}
