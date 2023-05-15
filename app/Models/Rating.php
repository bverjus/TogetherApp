<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';

    protected $fillable = [
        'rated_user_id', 'rater_user_id', 'rate'
    ];

    public function ratedUser()
    {
        return $this->belongsTo(User::class, 'rated_user_id');
    }

    public function raterUser()
    {
        return $this->belongsTo(User::class, 'rater_user_id');
    }

}