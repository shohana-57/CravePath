<?php

namespace App\Http\Controllers;

use App\Models\FoodSpot;
use App\Models\VisitRequest;
use Illuminate\Http\Request;

class VisitRequestController extends Controller
{
    public function store(Request $request, FoodSpot $foodSpot)
    {
        $request->validate([
            'purpose' => 'nullable|string|max:200',
            'message' => 'nullable|string|max:500',
        ]);

        VisitRequest::create([
            'user_id' => auth()->id(),
            'food_spot_id' => $foodSpot->id,
            'purpose' => $request->purpose,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Your visit request was shared with the seller.');
    }
}
