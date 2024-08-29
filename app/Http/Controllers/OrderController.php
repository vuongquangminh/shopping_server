<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::query()->with(['user', 'nhanSu']);
        return response()->json($query->get(), 200);
    }
}
