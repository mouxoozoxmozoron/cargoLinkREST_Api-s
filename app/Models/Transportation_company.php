<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation_company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'bank_acount_number', 'bank_type', 'location', 'agent_logo', 'company_category', 'working_day', 'routes', 'email', 'contact'];

    //relation to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'transportation_companies_id');
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
}
