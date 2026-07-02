<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedSpot extends Model
{
    protected $fillable = ['user_id', 'food_spot_id'];

    public function foodSpot()
    {
        return $this->belongsTo(FoodSpot::class);
    }
}
