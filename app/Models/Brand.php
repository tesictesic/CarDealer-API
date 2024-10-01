<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'parent_id'];

    public function children()
    {
        return $this->hasMany(Brand::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(Brand::class, 'parent_id');
    }
    public function models()
    {
        return $this->hasMany(Model::class, 'brand_id');
    }
}
