<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DungLuong extends Model
{
    use HasFactory;

    protected $fillale = [
        'name',
        'description'
    ];
    public function product()
    {
        return $this->hasMany(Product::class, 'dung_luong_id');
    }
}
