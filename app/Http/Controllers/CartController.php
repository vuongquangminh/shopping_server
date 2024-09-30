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
    public function show(Request $request, $id)
    {
        $query = Cart::query()->where('user_id', $id)->orderBy('id')->with('product') // Tính tổng total_price
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

    public function updateRowField(Request $request, $id)
    {
        $field = $request->field; // Tên trường cần update
        $value = $request[$field];
        $price = $request->price;
        if (!$value) {
            return response()->json([
                'message' => 'Chỉnh sửa thaat bại',
            ], 400);
        }
        $query = Cart::findOrFail($id)->update([$field => $value, 'total_price' => $value * $price]);
        return response()->json([
            'message' => 'Chỉnh sửa thành công',
            'data' => $query
        ]);
    }

    public function destroy($id)
    {
        $query = Cart::findOrFail($id);
        $query->delete();
        return response()->json([
            'message' => "Xóa thành công",
            'data' => $query
        ]);
    }
}
