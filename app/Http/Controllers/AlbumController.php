<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Http\Resources\AlbumResource;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Album::all());
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
    public function show(Album $album)
    {
        $album->load([
            'artist', // Artist of the album itself
            'songs' => function($query) { // Songs in the album
                // Relationships needed by SongResource for EACH song
                $query->with(['artist', 'album', 'genre', 'language']); // Example order
            }
        ]);
        return new AlbumResource($album);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $albums)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $albums)
    {
        //
    }
}
