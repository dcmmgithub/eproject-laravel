<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
// Import the SongResource you want to use for formatting songs
use App\Http\Resources\SongResource;

class GenreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // Include the genre's own fields
            'id' => $this->id,
            'name' => $this->name,
            // Add any other genre fields you want to include, e.g.:
            // 'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Include the songs relationship, formatted using SongResource
            // 'whenLoaded' ensures this key is only added if the 'songs' relationship was eager-loaded
            'songs' => SongResource::collection($this->whenLoaded('songs')),
        ];
    }
}