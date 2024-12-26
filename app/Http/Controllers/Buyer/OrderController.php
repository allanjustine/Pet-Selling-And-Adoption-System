<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Pet;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\BuyerOrderRequest;
use App\Services\OtpService;

class OrderController extends Controller
{
    public function __construct()
    {
        DB::statement("SET SQL_MODE=''"); // set the strict to false
    }
    
    public function index()
    {
        return view('buyer.order.index', [
            'orders' => Order::with(['pet' => fn($query) => $query->with('media', 'category')])
            ->whereBelongsTo(auth()->user())
            ->groupBy('transaction_no')
            ->orderBy('status', 'ASC')
            ->latest()
            ->get(),
        ]);    
    }
    
    public function create(Pet $pet)
    {
        return view('buyer.order.create', [
            'pet' => $pet->load('user.seller_account','breed', 'category', 'media'),
            'payment_methods' => PaymentMethod::all(),
        ]);
    }

    public function store(BuyerOrderRequest $request, OrderService $service, OtpService $otp_service)
    {
        //check if the otp is correct
        if (!$otp_service->checkOtp($request->otp)) {
            
            $otp_service->clearOtp(); // empty otp

            return back()->with(['error' => 'Invalid OTP Code']);
        }

        $service->storeOrder( user: auth()->user(), request: $request); // handle order

        return to_route('buyer.orders.index')->with([
            'success' => "
            Thank you for successfully placing your order with us! We are thrilled to have you as our valued customer and want to assure you that your order is in good hands. \n
            Shortly, you will receive both an email and an SMS order update to keep you informed about the progress of your purchase. These notifications will provide you with all the necessary details, including the relevant information regarding your order.
            "
        ]);
    }

    public function show(Order $order)
    {
        return view('buyer.order.show', [
            'order' => $order->load(['pet' => fn($query) => $query->with('media', 'category', 'breed'), 'user.barangay'])
        ]);
    }
}