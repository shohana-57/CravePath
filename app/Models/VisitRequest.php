<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitRequest extends Model
{
    protected $fillable = [
        'user_id',
        'food_spot_id',
        'message',
        'purpose',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foodSpot()
    {
        return $this->belongsTo(FoodSpot::class);
    }
}
