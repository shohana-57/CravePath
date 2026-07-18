<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitedSpot extends Model
{
    protected $fillable = [
        'user_id',
        'shop_name',
        'area',
        'notes',
        'photo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
