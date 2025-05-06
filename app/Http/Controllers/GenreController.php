<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use Illuminate\Http\Request;
use App\Http\Resources\GenreResource;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Genres::all());
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
    public function show(Genres $genre)
    {
        
        // Eager load the 'songs' relationship.
        // CRITICAL: Also load the relationships needed BY SongResource FOR EACH song.
        $genre->load([
            'songs' => function ($query) {
                // Load relationships required by SongResource onto each song
                $query->with(['artist', 'album', 'genre', 'language']);
                // You could add ordering here too, e.g.: $query->orderBy('name');
            }
        ]);
        // Alternative shorter syntax if the above relations are simple direct ones:
        // $genre->load('songs.artist', 'songs.album', 'songs.genre', 'songs.language');

        // Return the GenreResource, which will handle formatting
        return new GenreResource($genre);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genres $genres)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genres $genres)
    {
        //
    }
}
