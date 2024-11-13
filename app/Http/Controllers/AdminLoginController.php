<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function loginadmin(LoginRequest $request)
    {
        $request->validated();

        $user = User::whereUsername($request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password) || $user->role !== 'admin') {
            return response([
                'message' => 'Invalid credentials'
            ], 422);
        }

        $token = $user->createToken('AdminToken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
