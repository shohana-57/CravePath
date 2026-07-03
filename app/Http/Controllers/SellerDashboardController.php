<?php

namespace App\Http\Controllers;

use App\Models\FoodSpot;
use App\Models\MenuItem;
use App\Models\Photo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
     public function index()
    {
        $spots = FoodSpot::where('user_id', auth()->id())->get();
        return view('seller.dashboard', compact('spots'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.create', compact('categories'));
    }
    public function update(Request $request, FoodSpot $foodSpot)
    {
        if ($foodSpot->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'area' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'price_range' => 'required|in:budget,mid,premium',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        $foodSpot->update($request->only([
            'name', 'description', 'area', 'address', 'price_range', 'category_id'
        ]));

        return redirect()->route('seller.dashboard')->with('success', 'Food spot updated!');
    }
    public function destroy(FoodSpot $foodSpot)
    {
        if ($foodSpot->user_id !== auth()->id()) {
            abort(403);
        }

        $foodSpot->delete();

        return redirect()->route('seller.dashboard')->with('success', 'Food spot deleted!');
    }
     public function addMenuItem(Request $request, FoodSpot $foodSpot)
    {
        if ($foodSpot->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        MenuItem::create([
            'food_spot_id' => $foodSpot->id,
            'name' => $request->name,
            'price' => $request->price,
        ]);

         return back()->with('success', 'Menu item added!');
    }
    public function addPhoto(Request $request, FoodSpot $foodSpot)
    {
        if ($foodSpot->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $path = $request->file('photo')->store('spot_photos', 'public');

        Photo::create([
            'food_spot_id' => $foodSpot->id,
            'user_id' => auth()->id(),
            'path' => $path,
        ]);

        return back()->with('success', 'Photo uploaded!');
    }

}
