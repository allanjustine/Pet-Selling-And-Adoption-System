<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SellerAccount\SellerAccountRequest;
use App\Models\SellerAccount;
use App\Services\ImageUploadService;

class SellerAccountController extends Controller
{
    public function create()
    {
        return view('buyer.seller_account.create');
    }

    public function store(SellerAccountRequest $request, ImageUploadService $service)
    {
        // check if the user has a pending approval

        $check_seller_account = SellerAccount::where('user_id', auth()->id())->pending()->first();

        if($check_seller_account)
        {
            return back()->with(['error' => 'Oops you already have an existing application. Please kindly wait for updates. You will receive an email update once the admin has made a decision regarding to your application']);
        }

        $seller_account = auth()->user()->seller_account()->create($request->validated());

        // auth()->user()->update(['role_id' => Role::SELLER ]);

        if($request->proof_of_ownership)
        {
            $service->handleImageUpload(model:$seller_account, images: $request->proof_of_ownership, collection:'proof_of_ownership', conversion_name:'card', action:'create');
        }

        return back()->with(['success' => 'Submitted Successfully. You will receive an email update once the admin has made a decision regarding to your application. In the meantime, feel free to explore our website for more exciting pet-related content and services. We appreciate your trust and look forward to helping you find the perfect home for your furry friend!']);
    }
}