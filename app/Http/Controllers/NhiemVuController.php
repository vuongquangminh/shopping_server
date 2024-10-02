<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NhiemVuController extends Controller
{
    //

    public function index()
    {
        $user_id = Auth::user()->id;
        $query = Order::query()->where('nhan_su_id', $user_id)->with(['user'])->orderBy('id')->get();
        return $query;
    }

    public function nhiemVu(Request $request, $id)
    {
        $query = Order::findOrFail($id);
        if ($request->req == 'xac_nhan') {
            $query->update([
                'status' => 'dang_giao_hang'
            ]);
            return response()->json([
                "message" => "Xác nhận giao hàng"
            ]);
        } else {
            $query->update([
                'status' => 'tu_choi'
            ]);
            return response()->json([
                "message" => "Từ chối giao hàng"
            ]);
        }
    }

    public function donHang(Request $request, $id)
    {
        $query = Order::findOrFail($id);
        $query->update([
            'percent' => $request->percent
        ]);
        return response()->json([
            "message" => "Cập nhật thành công"
        ]);
    }
}
