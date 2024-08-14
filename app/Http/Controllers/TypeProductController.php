<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TypeProduct;
use Illuminate\Http\Request;

class TypeProductController extends Controller
{
    public function index()
    {
        $product = TypeProduct::query()->orderBy("id");
        return response()->json($product->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = TypeProduct::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return response()->json([
            "data" => $data,
            "message" => "Thêm mới loại sản phẩm thành công!"
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $query = TypeProduct::findOrFail($id);
        $data = $query->update(["name" => $request->input("name"), "description" => $request->input("description")]);
        return response()->json([
            "data" => $data,
            "message" => "Chỉnh sửa loại sản phẩm thành công!"
        ], 200);
    }


    public function destroy($id)
    {
        $query = TypeProduct::findOrFail($id);
        $query->delete();
    }
}
