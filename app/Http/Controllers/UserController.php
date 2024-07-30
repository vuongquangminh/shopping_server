<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {

        $user = User::query();

        return response()->json($user->get(), 200);
    }
}
