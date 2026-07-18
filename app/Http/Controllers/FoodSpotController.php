<?php

namespace App\Http\Controllers;

use App\Models\FoodSpot;
use App\Models\Category;
use App\Models\VisitedSpot;
use App\Services\WeatherService;
use Illuminate\Http\Request;


class FoodSpotController extends Controller
{
    public function index(Request $request)
    {
        $query = FoodSpot::where('is_approved', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('area')) {
            $query->where('area', 'like', '%'.$request->area.'%');

            // saving last search

             cookie()->queue(cookie('last_searched_area', $request->area, 60 * 24 * 7));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('price_range')) {
            $query->where('price_range', $request->price_range);
        }

        $spots = $query->latest()->get();
        $categories = Category::all();

        //reading last searching area from cookies
        $lastSearchedArea = $request->cookie('last_searched_area');

        return view('spots.index', compact('spots', 'categories', 'lastSearchedArea'));
    }
     public function show(Request $request, FoodSpot $foodSpot)
    {
        $foodSpot->load('menuItems', 'photos', 'reviews.user', 'category', 'seller');

        $weather = null;
        if ($foodSpot->area) {
            $weatherService = new WeatherService();
            $weather = $weatherService->getWeatherByCity($foodSpot->area);
        }

        return view('spots.show', compact('foodSpot', 'weather'));
    }

    
    //  returning JSON for search without page reload
    public function ajaxSearch(Request $request)
    {
        $query = FoodSpot::where('is_approved', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('area')) {
            $query->where('area', 'like', '%' . $request->area . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('price_range')) {
            $query->where('price_range', $request->price_range);
        }

        $spots = $query->latest()->get()->map(function ($spot) {
            return [
                'id'           => $spot->id,
                'name'         => $spot->name,
                'area'         => $spot->area,
                'price_range'  => ucfirst($spot->price_range),
                'avg_rating'   => number_format($spot->avg_rating, 1),
                'review_count' => $spot->review_count,
                'category'     => $spot->category ? $spot->category->name : null,
                'url'          => route('spots.show', $spot->id),
                'photo'        => $spot->photos->first()
                    ? asset('storage/' . $spot->photos->first()->path)
                    : null,
            ];
        });

        return response()->json($spots);
    }

    public function feed(Request $request)
    {
        $spots = FoodSpot::where('is_approved', true)
            ->latest()
            ->with('photos', 'category', 'reviews.user', 'seller')
            ->get();

        $weatherService = new WeatherService();
        $weatherBySpot = [];

        foreach ($spots as $spot) {
            if ($spot->area) {
                $weatherBySpot[$spot->id] = cache()->remember("weather:spot:{$spot->id}", now()->addMinutes(15), function () use ($weatherService, $spot) {
                    return $weatherService->getWeatherByCity($spot->area);
                });
            }
        }

        $visitedSpots = VisitedSpot::with('user')->latest()->get();

        return view('feed.index', compact('spots', 'visitedSpots', 'weatherBySpot'));
    }

    public function weather(FoodSpot $foodSpot)
    {
        if (! $foodSpot->area) {
            return response()->json(null, 404);
        }

        $weatherService = new WeatherService();
        $weather = $weatherService->getWeatherByCity($foodSpot->area);

        if (! $weather) {
            return response()->json(null, 404);
        }

        // update cache
        cache()->put("weather:spot:{$foodSpot->id}", $weather, now()->addMinutes(15));

        return response()->json($weather);
    }
}
