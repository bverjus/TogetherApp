<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modèle représentant une activité.
 */
class Activity extends Model
{
    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'category_id', 'user_id', 'place', 'description', 'date', 'image', 'duration', 'nb_attendees', 'address', 'city', 'country', 'lat', 'lon'
    ];

    /**
     * Obtient la catégorie associée à l'activité.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Obtient l'utilisateur associé à l'activité.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtient les participants associés à l'activité.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function participants()  
    {
        return $this->belongsToMany(User::class, 'participants_activites', 'activity_id', 'user_id');
    }
}