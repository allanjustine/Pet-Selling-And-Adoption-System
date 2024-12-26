<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
  
    use AuthenticatesUsers;

   
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
         // redirect to desired page by specific role allowed by GATE
         $credentials = $request->only('email', 'password');
     
         if(Auth::attempt($credentials) && $user->is_activated) 
         {
            $request->session()->regenerate();

            if($user->hasRole('admin')) {
               return redirect(route('admin.dashboard.index'));
            }

            if($user->hasRole('user')) {
               return redirect(route('user.dashboard.index'));
            }
          
         } 
         else 
         {

            $request->session()->flush();
            return redirect('/login')->with('message', 'Unauthorized User');

         }
    }
}
