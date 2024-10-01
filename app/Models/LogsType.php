<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsType extends Model
{
    use HasFactory;
    protected $table='logs_type';
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
