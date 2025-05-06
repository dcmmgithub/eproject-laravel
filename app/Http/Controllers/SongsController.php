<?php

namespace App\Http\Controllers;

use App\Models\Songs;
use App\Http\Resources\SongResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the relationships needed by the resource for efficiency
        $songs = Songs::with(['artist', 'album', 'genre', 'language'])->get();

        // Apply the SongResource to the entire collection
        // This will format each song in the collection according to SongResource::toArray()
        return SongResource::collection($songs);
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
        try {
            // The $song model is already available here thanks to Route Model Binding.
            // If the song wasn't found by ID in the URL, Laravel would have already returned a 404.

            // Eager load the relationships onto the existing $song model
            $song->load(['artist', 'album', 'genre', 'language']);

            // Return the resource
            // Make sure your SongResource is configured correctly
            // to handle these loaded relationships.
            return new SongResource($song);

        } catch (\Exception $e) {
            // This catch block is now less likely to be hit for "not found" errors,
            // but can catch other potential issues (e.g., problems within the SongResource).
            // Consider logging the actual error for debugging:
            \Log::error('Error showing song ID ' . $song->id . ': ' . $e->getMessage()); // Use Laravel's Log facade

            return response()->json(['message' => 'An unexpected error occurred while retrieving song details.'], 500); // More specific message?
        }
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

        $songs = Songs::query()->with(['artist', 'album']) // Keep eager loading
            ->where(function (Builder $query) use ($searchTerm) {
                $query->where('songs.name', 'LIKE', "%{$searchTerm}%");
                $query->orWhereHas('artist', function (Builder $artistQuery) use ($searchTerm) {
                    $artistQuery->where('artists.name', 'LIKE', "%{$searchTerm}%");
                });
                $query->orWhereHas('album', function (Builder $albumQuery) use ($searchTerm) { // Renamed variable for clarity
                    $albumQuery->where('albums.name', 'LIKE', "%{$searchTerm}%");
                });
            })
            ->orderBy('name')->get();

        // Also apply the resource collection here for consistent output
        if ($songs->isEmpty()) {
             return response()->json([], 200); // 200 OK with empty array is common for search results
            // Or keep 404 if you prefer:
            // return response()->json(['message' => 'No songs found matching your query.'], 404);
        }

        // Use the resource collection for search results too
        return SongResource::collection($songs);
    }
}
