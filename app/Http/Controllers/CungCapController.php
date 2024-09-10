<?php

namespace App\Http\Controllers;

use App\Models\Chip;
use App\Models\DungLuong;
use App\Models\MauSac;
use App\Models\User;
use Illuminate\Http\Request;

class CungCapController extends Controller
{
    public function customersAll()
    {
        $query = User::query()->where('role_name', 'customer');
        return response()->json($query->get());
    }
    public function nhanSuAll()
    {
        $query = User::query()->where('role_name', 'nhan_su');
        return response()->json($query->get());
    }

    public function chips(Request $request)
    {
        $type_product_id = $request->input('type_product_id');
        $query = Chip::query()->where('type_product_id', $type_product_id);
        return response()->json($query->get());
    }

    public function mauSacs(Request $request)
    {
        $type_product_id = $request->input('type_product_id');
        $query = MauSac::query()->where('type_product_id', $type_product_id);
        return response()->json($query->get());
    }

    public function dungLuongs()
    {
        $query = DungLuong::query();
        return response()->json($query->get());
    }
}
