<?php

namespace App\Http\Controllers;

use App\Models\FoodSpot;
use App\Models\Review;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\WeatherService;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $pendingSpots = FoodSpot::where('is_approved', false)->get();
        $flaggedReviews = Review::where('is_flagged', true)->get();
        $categories = Category::all();
        $allSpots = FoodSpot::with('seller', 'category')->latest()->get();

        return view('admin.dashboard', compact('pendingSpots', 'flaggedReviews', 'categories', 'allSpots'));
    }

    public function approveSpot(FoodSpot $foodSpot)
    {
        $foodSpot->is_approved = true;
        $foodSpot->save();

        return back()->with('success', 'Food spot approved!');
    }
     public function deleteSpot(FoodSpot $foodSpot)
    {
        $foodSpot->delete();
        return back()->with('success', 'Food spot removed!');
    }

    public function deleteReview(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review removed!');
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create(['name' => $request->name]);

        return back()->with('success', 'Category added!');
    }

    public function detail(FoodSpot $foodSpot)
    {
        $foodSpot->load('menuItems', 'photos', 'reviews.user', 'category', 'seller');

        $weather = null;
        if ($foodSpot->area) {
            $weatherService = new WeatherService();
            $weather = $weatherService->getWeatherByCity($foodSpot->area);
        }

        return view('admin.partials.spot_modal', compact('foodSpot', 'weather'));
    }

}
