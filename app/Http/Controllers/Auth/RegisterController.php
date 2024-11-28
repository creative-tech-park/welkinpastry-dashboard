<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken($request->header('sec-ch-ua-platform') ?? 'other')->plainTextToken;

        $responseData = [
            'token' => $token,
            'user' => $user,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful!',
            'data' => $responseData,
        ], 200);
    }
}