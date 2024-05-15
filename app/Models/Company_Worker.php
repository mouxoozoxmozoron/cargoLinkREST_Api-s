<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_Worker extends Model
{
    use HasFactory;

    protected $table = 'company_workers';


    protected $fillable = ['user_id', 'transportation_company_id', 'user_type_id'];

    //relations goes here
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
}
