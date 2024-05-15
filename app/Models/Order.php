<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'destination', 'user_id', 'driver_id', 'transportation_companies_id', 'receipt_image', 'cargo_image', 'quantity', 'position'];

    //relstions here
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transportation_company()
    {
        return $this->belongsTo(Transportation_company::class, 'transportation_companies_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
