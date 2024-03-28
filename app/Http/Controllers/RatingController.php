<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RatingRequest;
use App\Models\Book;
use App\Models\Rating;

class RatingController extends Controller
{
    public function addRating(RatingRequest $request, $bookId)
    {
        $book = Book::findOrFail($bookId);
        $user = auth()->user();

        $existingRating = Rating::where('book_id', $book->id)
                                ->where('user_id', $user->id)
                                ->first();

        if ($existingRating) {
            $existingRating->update([
                'rating' => $request->rating,
                'review' => $request->review
            ]);

            return response()->json(['message' => 'Rating and review updated successfully'], 200);
        } else {
            $rating = new Rating();
            $rating->rating = $request->rating;
            $rating->review = $request->review;
            $rating->user_id = $user->id;

            $book->ratings()->save($rating);

            return response()->json(['message' => 'Rating and review added successfully'], 201);
        }
    }   
}
