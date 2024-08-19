<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::query();
        return response()->json([
            "data" => $query->get(),
            "message" => "Lấy dữ liệu thành công"
        ]);
    }
}
