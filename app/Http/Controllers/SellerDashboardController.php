<?php

namespace App\Http\Controllers;

use App\Models\FoodSpot;
use App\Models\MenuItem;
use App\Models\Photo;
use App\Models\Category;
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

     public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'area'        => 'required|string|max:255',
            'address'     => 'nullable|string|max:255',
            'price_range' => 'required|in:budget,mid,premium',
            'category_id' => 'nullable|exists:categories,id',
            'photos.*'    => 'nullable|image|max:2048',
        ]);

        $spot = FoodSpot::create([
            'user_id'     => auth()->id(),
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'area'        => $request->area,
            'address'     => $request->address,
            'price_range' => $request->price_range,
            'is_approved' => false,
        ]);

        // multiple photo upload handling
         if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('spot_photos', 'public');
                Photo::create([
                    'food_spot_id' => $spot->id,
                    'user_id'      => auth()->id(),
                    'path'         => $path,
                ]);
            }
        }

        return redirect()->route('seller.dashboard')
            ->with('success', 'Food spot submitted for approval!');
    }

    public function edit(FoodSpot $foodSpot)
    {
        if ($foodSpot->user_id !== auth()->id()) abort(403);
        $categories = Category::all();
        $foodSpot->load('menuItems', 'photos');
        return view('seller.edit', compact('foodSpot', 'categories'));
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

    public function deleteMenuItem(MenuItem $menuItem)
    {
        if ($menuItem->foodSpot->user_id !== auth()->id()) abort(403);
        $menuItem->delete();
        return back()->with('success', 'Menu item removed!');
    }

}
