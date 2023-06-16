<?php

namespace App\Http\Controllers;

use App\Http\Requests\OtpRequest;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

            $randomString = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 10);
            $timestamp = time();
            $email = $randomString . $timestamp . '@example.com';
            $existingEmail = User::where('email', $email)->exists();

            if ($existingEmail) {
                $email = $randomString . $timestamp . '2@example.com';
            }

            $user = User::create([
                'name' => 'test',
                'surname' => 'test',
                'email' => $email,
                'gender' => 1,
                'birthday' => '2023-06-14 10:36:41',
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
