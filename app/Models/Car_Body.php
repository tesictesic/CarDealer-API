<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_Body extends Model
{
    use HasFactory;
    protected $table='car_body';
    protected $fillable=['name'];
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class,"car_body_id" );
    }
}
