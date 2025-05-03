<?php

namespace App\Http\Controllers;

use App\Models\Songs;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Search for songs by name.
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'q' => 'required|string|min:1',
        ]);

        $searchTerm = $validated['q'];

        $songs = Songs::query()->with(['artist', 'album'])
            ->where(function (Builder $query) use ($searchTerm) {

                $query->where('songs.name', 'LIKE', "%{$searchTerm}%");

                $query->orWhereHas('artist', function (Builder $artistQuery) use ($searchTerm) {
                    $artistQuery->where('artists.name', 'LIKE', "%{$searchTerm}%");
                });

                $query->orWhereHas('album', function (Builder $artistQuery) use ($searchTerm) {
                    $artistQuery->where('albums.name', 'LIKE', "%{$searchTerm}%");
                });

            })
            ->orderBy('name')->get();

        if ($songs->isEmpty()) {
            return response()->json([],404); // Use 404 Not Found status
        }

        return response()->json($songs);
    }
}
