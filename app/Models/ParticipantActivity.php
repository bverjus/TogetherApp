<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantActivity extends Model
{
    protected $table = 'participants_activites';

    protected $fillable = [
        'activity_id', 'user_id'
    ];

    public function activity()
    {
        return $this->belongsToMany(Activity::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
