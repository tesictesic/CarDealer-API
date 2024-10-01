<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable=['value','logs_type_id'];
    public function logstype()
    {
        return $this->belongsTo(LogsType::class);
    }
}
