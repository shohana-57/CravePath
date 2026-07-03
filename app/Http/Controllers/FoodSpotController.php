<?php

namespace App\Http\Controllers;

use App\Models\FoodSpot;
use App\Models\Category;
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
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('price_range')) {
            $query->where('price_range', $request->price_range);
        }

        $spots = $query->latest()->get();
        $categories = Category::all();

        return view('spots.index', compact('spots', 'categories'));
    }
     public function show(FoodSpot $spot)
    {
        $spot->load('menuItems', 'photos', 'reviews.user', 'category', 'seller');

        return view('spots.show', compact('foodSpot'));
    }

    
}
