<?php 

namespace App\Services;

use App\Models\Otp;

class OtpService
{
    public function checkOtp($code)
    {
        $otp =  Otp::where('otp', $code)->first();
        
        return $otp ? true : false ;
    }

    public function clearOtp()
    {
        return Otp::where('user_id', auth()->id())
                ->update(['otp' => null]);
    }

}