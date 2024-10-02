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
        $query = Order::query()->where('nhan_su_id', $user_id)->with(['user'])->get();
        return $query;
    }
}
