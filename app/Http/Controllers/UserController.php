<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = User::query()->orderBy('id');

        return response()->json($user->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required|max:255',
            'role_name' => 'required|max:255',
        ]);

        if ($request->hasFile('avatar')) {
            // Lấy file 'avatar' từ request
            $file = $request->file('avatar');

            // Tạo tên file duy nhất
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Lưu file vào thư mục public (hoặc thư mục bạn muốn) sử dụng Storage::disk
            $filePath = $file->storeAs('avatars', $fileName, 'public');

            // Đường dẫn công khai
            $public_url = Storage::url($filePath);

            // Lưu vào trong db
            $data = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'phone' => $request['phone'],
                'address' => $request['address'],
                'role_name' => $request['role_name'],
                'avatar' => $public_url,
            ]);
            return response()->json([
                'data' => $data,
                'message' => 'Thêm mới người dùng thành công'
            ], 200);
        } else {
            $data = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'phone' => $request['phone'],
                'address' => $request['address'],
                'role_name' => $request['role_name'],
            ]);
            return response()->json([
                'data' => $data,
                'message' => 'Thêm mới người dùng thành công'
            ], 200);
        }

        // Nếu không có file 'avatar', trả về thông báo lỗi
        return response()->json(['message' => 'Thêm mới người dùng không thành công'], 400);



        // return response()->json(['message' => "Thêm mới user thành công"]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . '|max:255',
            'password' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required|max:255',
            'role_name' => 'required|max:255',
        ]);


        $query = User::find($id);

        if ($query['avatar']) {
            $filePath = str_replace('/storage/', '', $query['avatar']);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }
        if ($request->hasFile('avatar')) {
            // Lấy file 'avatar' từ request
            $file = $request->file('avatar');

            // Tạo tên file duy nhất
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Lưu file vào thư mục public (hoặc thư mục bạn muốn) sử dụng Storage::disk
            $filePath = $file->storeAs('avatars', $fileName, 'public');

            // Đường dẫn công khai
            $public_url = Storage::url($filePath);


            //update dữ liệu
            $data =  $query->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'phone' => $request['phone'],
                'address' => $request['address'],
                'role_name' => $request['role_name'],
                'avatar' => $public_url,
            ]);
            return response()->json([
                'data' => $data,
                'message' => 'Chỉnh sửa người dùng thành công'
            ], 200);
        } else {
            $data = $query->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'phone' => $request['phone'],
                'address' => $request['address'],
                'role_name' => $request['role_name'],
            ]);
            return response()->json([
                'data' => $data,
                'message' => 'Chỉnh sửa người dùng thành công'
            ], 200);
        }

        // Nếu không có file 'avatar', trả về thông báo lỗi
        return response()->json(['message' => 'Chỉnh sửa người dùng không thành công'], 400);
    }
    public function destroy($id)
    {
        $query = User::findOrFail($id)->delete();
        return response()->json([
            'data' => $query,
            'message' => 'Chỉnh sửa người dùng không thành công'
        ], 200);
    }
}
