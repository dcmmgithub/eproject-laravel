<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Http\Resources\ArtistResource;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Artist::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        $artist->load([
            'albums' => function($query) {
                $query->orderBy('release_date', 'desc');
            },
            // Load some songs for the artist. Example: first 5 songs by name.
            // Adjust this query based on how you define "top" or "popular" songs.
            'songs' => function($query) {
                $query->orderBy('name')->limit(5); // Example: Get 5 songs by this artist
                // IMPORTANT: Also load relationships needed by SongResource for these songs
                $query->with(['artist', 'album', 'genre', 'language']);
            }
        ]);
        return new ArtistResource($artist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artist $artist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        //
    }
}
