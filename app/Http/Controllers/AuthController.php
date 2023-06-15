<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|string|unique:users',
            'code' => 'required|string'
        ]);

        if (Otp::query()->where([
            'phone' => $validatedData['phone'],
            'code' => $validatedData['code'],
        ])->exists())
        {
            $user = User::create([
                'name' => 'test',
                'email' => 'test',
                'password' => 'test',
                'phone' => $validatedData['phone']
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'İstifadəçi qeydiyyatdan keçdi.',
                'token' => $token,
            ], 201);
        }
        else{
            return response()->json([
                'message' => 'Təsdiqləmə kodunu düzgün daxil edin.',
            ], Response::HTTP_BAD_REQUEST);
        }


    }
    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');
        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $token = $user->createToken('api-token')->plainTextToken;
            return ['token' => $token];
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
