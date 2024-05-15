<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['first_name', 'last_name', 'phone_number', 'profile_image', 'email', 'password', 'user_type_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //Relation here
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    //relationsip of user to user type
    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    //relation with t.agent /company
    //user/driver works to even more company
    public function transportation_companies()
    {
        return $this->hasMany(Transportation_company::class, 'user_id');
    }

    //manager has one company
    public function transportation_companie()
    {
        return $this->hasOne(Transportation_company::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Transportation_company::class);
    }
}
