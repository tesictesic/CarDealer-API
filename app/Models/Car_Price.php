<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_Price extends Model
{
    use HasFactory;
    protected $table="car_price";
    protected $fillable=['vehicle_id','price','date_of','date_to'];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
