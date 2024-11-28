<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->only('email', 'password'), [
            'email' => ['required', 'string', 'lowercase', 'email','email:rfc'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message'=> 'Validation Error!',
                'error' => $validate->errors(),
            ], 403);
        }
        
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken($request->header('sec-ch-ua-platform') ?? 'other')->plainTextToken;
        $responseData = [
            'token' => $token,
            'user' => $user,
        ];
        
        return response()->json([
            'status' => 'success',
            'message' => 'login successfull!',
            'data' => $responseData,
        ], 200);
    }
}
