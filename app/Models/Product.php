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
        'camera',
        'chip_id',
        'dung_luong_id',
        'mau_sac_id',
    ];


    public function typeProduct(): BelongsTo
    {
        return $this->belongsTo(TypeProduct::class, 'type_product_id');
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }

    public function chip()
    {
        return $this->belongsTo(Chip::class, 'chip_id');
    }

    public function dungLuong()
    {
        return $this->belongsTo(DungLuong::class, 'dung_luong_id');
    }

    public function mauSac()
    {
        return $this->belongsTo(MauSac::class, 'mau_sac_id');
    }
}
