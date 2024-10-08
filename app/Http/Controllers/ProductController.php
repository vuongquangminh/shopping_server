<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::query()->orderBy("id")->with('typeProduct');
        return response()->json($product->get(), 200);
    }
    public function show(Request $request, $id)
    {
        $query = Product::query()->where('id', $id)->with(['chip', 'typeProduct']);
        return $query->get();
    }
    public function indexViewUser(Request $request)
    {
        $totalProduct = Product::count();
        $product = Product::query()->
            // where('name', 'like', "%{$request->search}%")
            whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->search) . '%'])
            ->orderBy("id")->with('typeProduct')->skip(($request->page - 1) * $request->pageSize)->take($request->pageSize);
        return response()->json(["product" => $product->get(), "total" => $totalProduct], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type_product_id' => 'required|integer',
            'description' => 'nullable|string',
            'camera' => 'nullable|string',
            'chip_id' => 'nullable|integer',
            'dung_luong_id' => 'nullable|integer',
            'mau_sac' => 'nullable|string',
            'pin' => 'nullable|string',
            'bao_mat' => 'nullable|string',
            'man_hinh' => 'nullable|string',
            'price' => 'required|integer',
            'so_luong' => 'required|integer',
            'chong_nuoc' => 'nullable|string',

        ]);

        if ($request->hasFile('image')) {
            // Lấy file 'avatar' từ request
            $file = $request->file('image');

            // Tạo tên file duy nhất
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Lưu file vào thư mục public (hoặc thư mục bạn muốn) sử dụng Storage::disk
            $filePath = $file->storeAs('images', $fileName, 'public');

            // Đường dẫn công khai
            $public_url = Storage::url($filePath);

            // Lưu vào trong db
            $data = Product::create([
                'name' => $request['name'],
                'type_product_id' => $request['type_product_id'],
                'description' => $request['description'],
                'price' => $request['price'],
                'camera' => $request['camera'],
                'chip_id' => $request['chip_id'],
                'dung_luong_id' => $request['dung_luong_id'],
                'mau_sac' => $request['mau_sac'],
                'so_luong' => $request['so_luong'],
                'pin' => $request['pin'],
                'bao_mat' => $request['bao_mat'],
                'man_hinh' => $request['man_hinh'],
                'chong_nuoc' => $request['chong_nuoc'],
                'image' => $public_url,
            ]);
            return response()->json([
                'data' => $data,
                'message' => 'Thêm mới sản phẩm thành công'
            ], 200);
        } else {
            $data = Product::create([
                'name' => $request['name'],
                'type_product_id' => $request['type_product_id'],
                'description' => $request['description'],
                'price' => $request['price'],
                'so_luong' => $request['so_luong'],
                'camera' => $request['camera'],
                'chip_id' => $request['chip_id'],
                'dung_luong_id' => $request['dung_luong_id'],
                'mau_sac' => $request['mau_sac'],
                'pin' => $request['pin'],
                'bao_mat' => $request['bao_mat'],
                'man_hinh' => $request['man_hinh'],
                'chong_nuoc' => $request['chong_nuoc'],
            ]);
            return response()->json([
                'data' => $data,
                'message' => 'Thêm mới sản phẩm thành công'
            ], 200);
        }

        // Nếu không có file 'avatar', trả về thông báo lỗi
        return response()->json(['message' => 'Thêm mới sản phẩm không thành công'], 400);
    }

    public function update(Request $request, $id)
    {
        $query = Product::findOrFail($id);


        $request->validate([
            'name' => 'required|string|max:255',
            'type_product_id' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'required|integer',
            'so_luong' => 'required|integer',
            'camera' => 'nullable|string',
            'chip_id' => 'nullable|integer',
            'dung_luong_id' => 'nullable|integer',
            'pin' => 'nullable|string',
            'bao_mat' => 'nullable|string',
            'man_hinh' => 'nullable|string',
            'mau_sac' => 'nullable|string',
            'chong_nuoc' => 'nullable|string',

        ]);


        if ($query['image']) {
            $filePath = str_replace('/storage/', '', $query['image']);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }
        if ($request->hasFile('image')) {
            // Lấy file 'avatar' từ request
            $file = $request->file('image');

            // Tạo tên file duy nhất
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Lưu file vào thư mục public (hoặc thư mục bạn muốn) sử dụng Storage::disk
            $filePath = $file->storeAs('images', $fileName, 'public');

            // Đường dẫn công khai
            $public_url = Storage::url($filePath);


            //update dữ liệu
            $data =  $query->update([
                'name' => $request['name'],
                'type_product_id' => $request['type_product_id'],
                'description' => $request['description'],
                'price' => $request['price'],
                'so_luong' => $request['so_luong'],
                'camera' => $request['camera'],
                'chip_id' => $request['chip_id'],
                'dung_luong_id' => $request['dung_luong_id'],
                'mau_sac' => $request['mau_sac'],
                'pin' => $request['pin'],
                'bao_mat' => $request['bao_mat'],
                'chong_nuoc' => $request['chong_nuoc'],
                'man_hinh' => $request['man_hinh'],
                'image' => $public_url,
            ]);
            return response()->json([
                'data' => $data,
                'message' => 'Chỉnh sửa sản phẩm thành công'
            ], 200);
        } else {
            $data = $query->update([
                'name' => $request['name'],
                'type_product_id' => $request['type_product_id'],
                'description' => $request['description'],
                'price' => $request['price'],
                'so_luong' => $request['so_luong'],
                'camera' => $request['camera'],
                'chip_id' => $request['chip_id'],
                'dung_luong_id' => $request['dung_luong_id'],
                'mau_sac' => $request['mau_sac'],
                'pin' => $request['pin'],
                'bao_mat' => $request['bao_mat'],
                'man_hinh' => $request['man_hinh'],
                'chong_nuoc' => $request['chong_nuoc'],
                'image' => '',
            ]);
            return response()->json([
                'data' => $data,
                'message' => 'Chỉnh sửa sản phẩm thành công'
            ], 200);
        }

        // Nếu không có file 'avatar', trả về thông báo lỗi
        return response()->json(['message' => 'Chỉnh sửa sản phẩm không thành công'], 400);
    }


    public function destroy($id)
    {
        $query = Product::findOrFail($id);
        $query->delete();
    }
}
