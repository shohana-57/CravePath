<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
       protected $fillable = [
        'food_spot_id',
        'user_id',
        'rating',
        'remarks',
        'seller_reply',
        'is_flagged',
    ];

    public function foodSpot()
    {
        return $this->belongsTo(FoodSpot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
