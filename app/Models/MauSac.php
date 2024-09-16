<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MauSac extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type_product_id'

    ];

    // public function product()
    // {
    //     return $this->hasMany(Product::class, 'mau_sac_id');
    // }

    public function typeProduct()
    {
        return $this->belongsTo(TypeProduct::class, 'type_product_id');
    }
}
