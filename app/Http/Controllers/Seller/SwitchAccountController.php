<?php

namespace App\Http\Controllers\Seller;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SwitchAccountController extends Controller
{
    public function __invoke(User $user)
    {
        $user->update(['role_id' => $user->role_id == Role::BUYER ? Role::SELLER : Role::BUYER ]);

        Auth::login($user);

        return match ($user->role->name) {
            'seller' => to_route('seller.dashboard.index')->with(['switch_account_response' => 'You are now logged in as Seller']),
            'buyer' => to_route('buyer.dashboard.index')->with(['switch_account_response' => 'You are now logged in as Buyer']),
        };
    }
}