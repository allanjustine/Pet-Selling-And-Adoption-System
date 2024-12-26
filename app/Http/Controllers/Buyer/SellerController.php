<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Pet;
use App\Models\Adoption;
use Illuminate\Http\Request;
use App\Models\SellerAccount;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function __invoke(SellerAccount $seller)
    {
        return view('buyer.seller.show', [
            'seller' => $seller->load('user', 'user.ratings'),
            'pets' => Pet::with('breed', 'media')->whereBelongsTo($seller->user)->latest()->paginate(10),
            'adoptions' => Adoption::with('breed', 'media')->whereBelongsTo($seller->user)->latest()->paginate(10),
            //'seller' => $seller->load([ 'user.pets' => fn($query) => $query->with('breed', 'media') ]),
        ]);
    }
}