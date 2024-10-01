<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicing extends Model
{
    use HasFactory;
    protected $fillable=['order_id','user_id','date_to','note'];
    protected $table='servicing';
    public function service_items()
    {
        return $this->hasMany(ServiceItems::class);
    }
}
