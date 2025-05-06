<?php

namespace App\Http\Controllers;

use App\Models\AlbumReview;
use App\Models\Album;
use App\Http\Requests\StoreAlbumReviewRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AlbumReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexForAlbum(Album $album, Request $request): JsonResponse
    {
        // Eager load the 'user' relationship for each review
        // Order by newest first, for example
        $reviews = $album->reviews()->with('user')->latest()->paginate(10); // Example pagination

        return response()->json($reviews);
    }

    public function storeForAlbum(StoreAlbumReviewRequest $request, Album $album): JsonResponse
    {
        // Validation passed. Authorization check is removed from FormRequest.

        // Get validated data (now includes comment, rating, date)
        $validated = $request->validated();

        // Get user ID ONLY if the user is authenticated
        $userId = Auth::check() ? Auth::id() : null;

        // Create the review using the relationship
        $review = $album->reviews()->create([
            'user_id' => $userId, // Will be null if user is not logged in
            'comment' => $validated['comment'],
            'rating' => $validated['rating'],
            'date' => now()->toDateString(), // <-- Set current date automatically
            'name' => $validated['name'], // <-- Add 'name'
        ]);

        // Conditionally load user if it exists
        if ($review->user_id) {
            $review->load('user');
        }

        return response()->json([
            'message' => 'Review submitted successfully!',
            'review' => $review // Or new ReviewResource($review)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AlbumReview $albumReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlbumReview $albumReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlbumReview $albumReview)
    {
        //
    }
}
