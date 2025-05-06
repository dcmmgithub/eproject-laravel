<?php

namespace App\Http\Controllers;

use App\Models\ArtistReview;
use App\Models\Artist;
use App\Http\Requests\StoreArtistReviewRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ArtistReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Artist $artist, Request $request): JsonResponse
    {
        // Eager load the 'user' relationship for each review
        // Order by newest first, for example
        $reviews = $artist->reviews()->with('user')->latest()->get(); // Example pagination

        return response()->json($reviews);
    }

    public function store(StoreArtistReviewRequest $request, Artist $artist): JsonResponse
    {
        // Validation passed. Authorization check is removed from FormRequest.

        // Get validated data (now includes comment, rating, date)
        $validated = $request->validated();

        // Get user ID ONLY if the user is authenticated
        $userId = Auth::check() ? Auth::id() : null;

        // Create the review using the relationship
        $review = $artist->reviews()->create([
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
    public function show(ArtistReview $artistReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArtistReview $artistReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArtistReview $artistReview)
    {
        //
    }
}
