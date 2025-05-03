<?php

namespace App\Http\Controllers;

use App\Models\Songs;
use Illuminate\Http\Request;

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Songs::with(['artist', 'album', 'genre', 'language'])->get();
        return response()->json($songs);
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
    public function show(Songs $song)
    {
        $song->load(['artist', 'album', 'genre', 'language']);
        return response()->json($song);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Songs $songs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Songs $songs)
    {
        //
    }
}
