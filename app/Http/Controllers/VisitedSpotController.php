<?php

namespace App\Http\Controllers;

use App\Models\VisitedSpot;
use Illuminate\Http\Request;

class VisitedSpotController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('visited_spots', 'public');
        }

        VisitedSpot::create([
            'user_id' => auth()->id(),
            'shop_name' => $request->shop_name,
            'area' => $request->area,
            'notes' => $request->notes,
            'photo_path' => $path,
        ]);

        return back()->with('success', 'Visited shop shared for others.');
    }
}
