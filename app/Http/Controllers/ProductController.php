<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TypeProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = TypeProduct::query();
        return response()->json($product->get(), 200);
    }
}
