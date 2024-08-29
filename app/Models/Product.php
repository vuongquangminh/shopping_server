<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type_product_id',
        'description',
        'price',
        'image',
        'so_luong',
    ];

    public function typeProduct(): BelongsTo
    {
        return $this->belongsTo(TypeProduct::class, 'type_product_id');
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }
}
