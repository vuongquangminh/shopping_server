<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function show($id)
    {
        $query = Cart::query()->where('user_id', $id) // Tính tổng total_price
            ->get();

        return $query;
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $product_id = $request->input('product_id');
        $so_luong = $request->input('so_luong');
        $total_price = $request->input('total_price');
        $data = Cart::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'so_luong' => $so_luong,
            'total_price' => $total_price
        ]);

        return response()->json([
            'data' => $data,
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công'
        ]);
    }
}
