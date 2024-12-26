<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Barangay;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendEmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register', [
            'barangays' => Barangay::pluck('name', 'id'),
        ]);
    }

    public function attemptLogin(Request $request)
    {
        // redirect to desired page by specific role allowed by GATE
        $credentials = $request->only('email', 'password');
            
        if (!Auth::attempt($credentials + ['is_activated' => true])) 
        {
            $request->session()->flush();
            
            return redirect('/login')->with('warning', 'The Username / Password do not match');
        } 

        Auth::logoutOtherDevices($request->password); // Log in the user and invalidate other sessions

        $request->session()->regenerate();

        $this->log_activity(model: auth()->user(), event:'login', model_name: 'Account', model_property_name: auth()->user()->name, conjunction:'an');

        return match (auth()->user()->role->name) {
            'admin' => to_route('admin.dashboard.index'),
            'seller' => to_route('seller.pets.index'),
            'buyer' => to_route('buyer.pets.index'),
        };
    }

    public function attemptRegister(AuthRequest $request)
    {
        $form_data = $request->validated();
        $form_data['password'] = bcrypt($request->password);

        $user = User::create($form_data + [
            'role_id' => \App\Models\Role::BUYER,
            'verification_token' => Str::uuid(),
        ]);

        $email_verification_route = route('auth.email_verification', $user->verification_token);  

        Mail::to($user)->send(new SendEmailVerification(user: $user, email_verification_route: $email_verification_route));  // send email verification
 
        return back()->with(['success' => 'Registration submitted successfully. A fresh verification link has been sent to your email address. Verify first your email address to complete your registration.']);
    }
    
    public function emailVerification($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) 
        {
            return to_route('auth.login')->with('error', 'Invalid Token!'); // redirect to login
        }

        $user->update(['is_activated' => true, 'email_verified_at' => now(), 'verification_token' => null]);

        return to_route('auth.login')->with('success', 'Account activated successfully: You can now login to our platform'); // redirect to login
    }

   
    public function logout(Request $request)
    {
        $this->log_activity(model: auth()->user(), event:'logout', model_name: 'Account', model_property_name: auth()->user()->name, conjunction:'an');

        Auth::logout();

        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
        
        return redirect(route('auth.login'));
    }
}