<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable=['service_packet_id','name','description','icon','price'];
    public function service_pack()
    {
        return $this->belongsTo(Service_Pack::class);
    }
    public function service_items()
    {
        return $this->hasMany(ServiceItems::class);
    }
}
