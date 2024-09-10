<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chip extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type_product_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'chip_is');
    }

    public function typeProduct()
    {
        return $this->belongsTo(TypeProduct::class, 'type_product_id');
    }
}
