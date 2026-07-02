<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['food_spot_id', 'name', 'price', 'photo'];

    public function foodSpot()
    {
        return $this->belongsTo(FoodSpot::class);
    }
}
