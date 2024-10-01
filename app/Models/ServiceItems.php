<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItems extends Model
{
    use HasFactory;
    protected $fillable=['service_id','servicing_id'];
    protected $table='servicing_items';
    public function servicing()
    {
        return $this->belongsTo(Servicing::class);
    }
    public function services()
    {
        return $this->belongsTo(Service::class);
    }
}
