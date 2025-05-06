<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
// Import the SongResource you want to use for formatting songs
use App\Http\Resources\SongResource;

class ArtistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'albums' => AlbumResource::collection($this->whenLoaded('albums')),
            'songs' => SongResource::collection($this->whenLoaded('songs')),
        ];
    }
}