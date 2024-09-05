<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Passwordcontroller extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'newPassword' => 'required',
        ]);
        $user_id = Auth::user()->id;
        $oldPassword = $request->get('oldPassword');
        $newPassword = $request->get('newPassword');
        $query = User::findOrFail($user_id);

        if (Hash::check($oldPassword, $query->password)) {
            $query->update([
                'password' => Hash::make($newPassword)
            ]);
            return response()->json([
                "message" => "Đổi mật khẩu thành công!"
            ]);
        }
        return response()->json(['message' => 'Mật khẩu cũ không đúng'], 400);
    }
}
