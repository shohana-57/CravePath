<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodSpot extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'area',
        'address',
        'contact_number',
        'contact_email',
        'map_link',
        'video_url',
        'opening_hours',
        'price_range',
        'avg_rating',
        'review_count',
        'is_approved',
    ];

     public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function visitRequests()
    {
        return $this->hasMany(VisitRequest::class);
    }
}



    

   
