<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'first_name',
        'last_name',
        'profile_photo_path',
        'birth',
        'city',
        'country',
        'street',
        'house_number',
        'zip_code',
        'phone',
        'intro',
        'description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function adminActivities()
    {
        return $this->hasMany(Activity::class, 'user_id');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'participants_activites', 'user_id', 'activity_id')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'users_categories', 'user_id', 'category_id')->withTimestamps();
    }

    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'rated_user_id', 'id');
    }

    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'rater_user_id');
    }

    public function averageRating()
    {
        return $this->ratingsReceived()->avg('rate');
    }
}
