<?php

namespace App\Http\Controllers;
use App\Models\FoodSpot;
use App\Models\SavedSpot;
use Illuminate\Http\Request;

class SavedSpotController extends Controller
{
     public function index()
    {
        $saved = SavedSpot::where('user_id', auth()->id())->with('foodSpot')->get();
        return view('saved.index', compact('saved'));
    }

    public function store(FoodSpot $foodSpot)
    {
        SavedSpot::firstOrCreate([
            'user_id' => auth()->id(),
            'food_spot_id' => $foodSpot->id,
        ]);

        return back()->with('success', 'Spot saved!');
    }
    public function destroy(FoodSpot $foodSpot)
    {
        SavedSpot::where('user_id', auth()->id())
            ->where('food_spot_id', $foodSpot->id)
            ->delete();

        return back()->with('success', 'Removed from saved spots.');
    }
}
