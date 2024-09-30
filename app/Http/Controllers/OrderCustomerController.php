<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderCustomerController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $query = Order::query()->where('user_id', $user_id)->with(['orderProduct', 'orderProduct.product'])->get();
        return $query;
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        DB::transaction(function () use ($user_id, $request) {
            $order = Order::create([
                'user_id' => $user_id,
                'total_price' => $request->total_price,
                'status' => "cho_nhan_viec"
            ]);
            $datHangs = $request->datHangs;
            foreach ($datHangs as $datHang) {
                OrderProduct::insert([
                    'product_id' => $datHang['product_id'],
                    'order_id' => $order->id,
                    'so_luong' => $datHang['so_luong'],
                ]);
                Cart::find($datHang['id'])->delete();
            };

            return response()->json([
                'message' => "Thành công",
                'data' => $order
            ], 200);
        });
    }
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            OrderProduct::query()->where('order_id', $id)->delete();
            $query = Order::findOrFail($id);
            $query->delete();
            return response()->json([
                "message" => "Xóa thành công",
                "data" => $query
            ], 200);
        });
    }
}
