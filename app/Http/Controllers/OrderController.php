<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::query()->with(['user', 'nhanSu']);
        return response()->json($query->get(), 200);
    }


    public function show($id)
    {
        $query = OrderProduct::query()->where('order_id', $id)->with(['order', 'order.user', 'product'])->get();
        return $query;
    }

    public function update(Request $request,  $id)
    {
        $nhan_su_id = $request->input('nhan_su_id');
        $ngay_han = $request->get('ngay_han');

        $data = Order::findOrFail($id);
        // return $data;
        $data->update([
            "nhan_su_id" => $nhan_su_id,
            "ngay_han" => $ngay_han,
            "status" => "cho_nhan_viec"
        ]);
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $query = Order::findOrFail($id);
        $query->update([
            'status' => 'huy'
        ]);
        return response(['message' => "Hủy đơn thành công"], 200);
    }
}
