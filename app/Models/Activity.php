<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'title', 'category_id', 'user_id', 'place', 'description', 'date', 'image', 'duration', 'nb_attendees', 'address', 'city', 'country', 'lat', 'lon'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()  
    {
        return $this->belongsToMany(User::class, 'participants_activites', 'activity_id', 'user_id');
    }
}