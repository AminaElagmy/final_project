<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $table    = 'regions';
    protected $fillable = ['name','govern_id'];

    public function government()
    {
        return $this->belongsTo(Governorate::class,'govern_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'region_id');
    }
}
