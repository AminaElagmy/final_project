<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    use HasFactory;

    protected $table    = 'product_details';
    protected $fillable = ['name', 'email', 'phone','desc','image','location','service'
                            ,'mission','vision','about','product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
