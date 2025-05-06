<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Determine the image URL using the priority logic
        $imageUrl = $this->getImageUrl();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'release_date' => $this->release_date, // Consider formatting this date/time
            'audio' => $this->audio,
            // Use the determined image URL
            'image_url' => $imageUrl,
            // Keep relationship names if needed, or remove if image_url replaces them visually
            'artist' => $this->whenLoaded('artist', fn() => $this->artist?->name),
            'album' => $this->whenLoaded('album', fn() => $this->album?->name),
            'genre' => $this->whenLoaded('genre', fn() => $this->genre?->name),
            'language' => $this->whenLoaded('language', fn() => $this->language?->name),

            // Alternative: Include full artist/album objects if needed by frontend
            // 'artist_details' => new ArtistResource($this->whenLoaded('artist')),
            // 'album_details' => new AlbumResource($this->whenLoaded('album')),
        ];
    }

    private function getImageUrl(): ?string
    {
        // --- Priority 1: Album Cover ---
        // Check if album relationship is loaded, the album exists, and it has an image property set
        if ($this->whenLoaded('album') && $this->album && $this->album->image) {
            return $this->album->image;
        }

        // --- Priority 2: Artist Image ---
        // Check if artist relationship is loaded, the artist exists, and it has an image property set
        if ($this->whenLoaded('artist') && $this->artist && $this->artist->image) {
             return $this->artist->image;
        }

        // --- Fallback: No image found ---
        // Option 1: Return null
        return null;

        // Option 2: Return a default placeholder image URL
        // return url('images/default_song_placeholder.png'); // Make sure this image exists in your public folder
    }
}