<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
{
    $validatedData = $request->validated();

    $userData = [
        'nom' => $request->nom,
        'prenom' => $request->nom,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ];

    $user = User::create($userData);
    $token = $user->createToken('forumapp')->plainTextToken;

    return response([
        'user' => $user,
        'token' => $token
    ], 201);
}
public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::whereUsername($request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Invalid credentials'
            ], 422);
        }

        $token = $user->createToken('forumapp')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }
    
}