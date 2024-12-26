<?php

namespace Illuminate\Foundation\Auth;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return match (auth()->user()->role->name) {
            'admin' => route('admin.dashboard.index'),
            'seller' => route('seller.pets.index'),
            'buyer' => route('buyer.pets.index'),
        };
    }
}