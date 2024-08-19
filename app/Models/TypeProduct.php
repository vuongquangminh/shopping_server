<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'type_product_id');
    }
}
