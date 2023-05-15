<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'nom', 'image'
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class, 'category_id');
    }
}