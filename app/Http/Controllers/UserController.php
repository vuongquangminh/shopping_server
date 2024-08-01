<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::query();

        return response()->json($user->get(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|min:1', // Thêm quy tắc tối thiểu cho độ tuổi
        ]);
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone'],
            'address' => $request['address'],
            'role_name' => $request['role_name'],
            'avatar' => $request['avatar'],
        ]);
        return response()->json(['message' => "Thêm mới user thành công"]);
    }
}
