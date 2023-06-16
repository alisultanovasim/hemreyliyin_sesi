<?php

namespace App\Http\Controllers;

use App\Http\Requests\OtpRequest;
use App\Models\Otp;
use Illuminate\Http\Request;
use App\Library\SendSMS;
use Symfony\Component\HttpFoundation\Response;

class OtpController extends Controller
{
    public function sendOtp(OtpRequest $request)
    {
        try {
            $randomCode = rand(1000, 9999);
            SendSMS::send($request->phone, 'Sizin hemreylik kodunuz: '.$randomCode);

            Otp::create([
                'phone' => $request->phone,
                'code' => $randomCode
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Təsdiq kodu nömrəyə göndərildi.',
//                'data' => [
//                    'OTPcode' => $randomCode
//                ]
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e,
                'message' => 'Problem yarandı.Biraz sonra yenidən sınayın.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
