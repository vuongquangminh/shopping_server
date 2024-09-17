<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $query = Cart::query()->select('user_id', DB::raw('SUM(total_price) as total_sum')) // Tính tổng total_price
            ->groupBy('user_id') // Nhóm theo user_id
            ->get();

        return $query;
    }

    public function store() {}
}
