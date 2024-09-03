<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoanhSoController extends Controller
{
    public function index()
    {
        $query = OrderProduct::query()->select('product_id', DB::raw('SUM(so_luong) as total_quantity')) // Đảm bảo đóng ngoặc đúng cách
            ->groupBy('product_id')
            ->with(['product']);
        return response()->json($query->get(), 200);
    }
}
