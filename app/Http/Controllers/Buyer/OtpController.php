<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Otp\OtpRequest;
use App\Services\TextService;

class OtpController extends Controller
{
    public function __invoke(OtpRequest $request, TextService $service)
    {
        $otp = mt_rand(123456, 999999);

        //Mail::to($request->email)->send(new SendOtp($otp)); // send otp to user

        $service->send(recipient:$request->contact, message: "To process your order from Furfect you are required to enter the following code. Your OTP code is: $otp");    // send SMS

        Otp::updateOrCreate(
            ['user_id' => auth()->id()],
            ['otp' => $otp,]
        );

        return $this->res(['message' => 'OTP code has been sent to your contact number. Please check and apply it to the OTP input field']);
    }
}