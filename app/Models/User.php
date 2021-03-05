<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function fullname() : String {
        return ucwords($this->firstname.' '.$this->lastname);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function kin()
    {
        return $this->hasOne(Kin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function company()
    {
        return json_decode($this->company);
    }

    public function user_data()
    {
        return json_decode($this->user_data);
    }

    public function setCompanyAttribute($value)
    {
        $this->attributes['company'] = json_encode($value);
    }

    public function setUserDataAttribute($value)
    {
        $this->attributes['user_data'] = json_encode($value);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
