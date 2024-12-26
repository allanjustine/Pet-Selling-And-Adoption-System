<?php

namespace App\Http\Controllers\Buyer;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class SwitchAccountController extends Controller
{
    public function __invoke(User $user)
    {
        $user->update(['role_id' => $user->role_id == Role::BUYER ? Role::SELLER : Role::BUYER ]);

        Auth::login($user);

        return match ($user->role->name) {
            'seller' => to_route('seller.pets.index')->with(['switch_account_response' => 'You are now logged in as Seller']),
            'buyer' => to_route('buyer.pets.index')->with(['switch_account_response' => 'You are now logged in as Buyer']),
        };
    }
}