<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_Pack extends Model
{
    use HasFactory;
    protected $table='service_packs';
    protected $fillable=['name'];
    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
