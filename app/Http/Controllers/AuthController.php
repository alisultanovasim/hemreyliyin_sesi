<?php

namespace App\Http\Controllers;

use App\Http\Requests\OtpRequest;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        ],
        [
            'phone.required' => 'Telefon nömrənizi daxil edin.',
            'code.required' => 'SMS vasitəsi ilə gələn təsdiq kodunuzu daxil edin.',
            'phone.unique' => 'Telefon nömrənisi hal-hazırda bazada mövcuddur.',
        ]);

        $checkOTP = Otp::query()
            ->where(['phone' => $validatedData['phone'],'code' => $validatedData['code']])
            ->orderByDesc('created_at')
            ->first();

        if ($checkOTP && Carbon::parse($checkOTP->created_at)->diffInMinutes(Carbon::now()) <= 3)
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
    public function login(OtpRequest $request)
    {
        $credentials = [
            'phone' => $request->input('phone'),
        ];

        $user = User::where('phone', $credentials['phone'])->first();

        if ($user) {
            Auth::login($user);
            $token = $user->createToken('api-token')->plainTextToken;
            return ['token' => $token];
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
