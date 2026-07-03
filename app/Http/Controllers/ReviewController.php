<?php

namespace App\Http\Controllers;

use App\Models\FoodSpot;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, FoodSpot $foodSpot)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'remarks' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'food_spot_id' => $foodSpot->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'remarks' => $request->remarks,
        ]);

        $foodSpot->avg_rating = $foodSpot->reviews()->avg('rating');
        $foodSpot->review_count = $foodSpot->reviews()->count();
        $foodSpot->save();

        return back()->with('success', 'Review submitted!');
    }
    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'seller_reply' => 'required|string|max:1000',
        ]);

        if ($review->foodSpot->user_id !== auth()->id()) {
            abort(403);
        }

        $review->seller_reply = $request->seller_reply;
        $review->save();

        return back()->with('success', 'Reply posted!');
    }
    public function flag(Review $review)
    {
        $review->is_flagged = true;
        $review->save();

        return back()->with('success', 'Review reported to admin.');
    }
}
