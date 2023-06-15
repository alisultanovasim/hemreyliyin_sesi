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
        $randomCode = rand(1000, 9999);
        SendSMS::send($request->phone,$randomCode);

        Otp::query()->create([
           'phone' => $request->phone,
           'code'  => $randomCode
        ]);

        return response()->json(['status'=>'success','OTPcode'=>$randomCode,'message'=>'Təsdiq kodu nömrəyə göndərildi.'],Response::HTTP_OK);
    }

    public function checkOTP(Request $request)
    {
//        if ($request->code)
    }
}
