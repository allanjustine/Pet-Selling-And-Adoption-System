<?php

namespace App\Http\Controllers\Seller;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        DB::statement("SET SQL_MODE=''"); // set the strict to false
    }
    
    public function index()
    {
        return view('seller.order.index', [
            'orders' => Order::with(['pet' => fn($query) => $query->with('media', 'category')])
            ->whereRelation('pet', 'user_id', auth()->id())
            ->where('status', Order::DELIVERED)
            ->groupBy('transaction_no')
            ->orderBy('status', 'ASC')
            ->latest()
            ->get(),
        ]);    
    }

    public function show(Order $order)
    {
        return view('seller.order.show', [
            'order' => $order->load(['pet' => fn($query) => $query->with('media', 'category', 'breed'), 'user.barangay'])
        ]);
    }
}