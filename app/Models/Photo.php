<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
     protected $fillable = ['food_spot_id', 'user_id', 'path'];

    public function foodSpot()
    {
        return $this->belongsTo(FoodSpot::class);
    }
}
