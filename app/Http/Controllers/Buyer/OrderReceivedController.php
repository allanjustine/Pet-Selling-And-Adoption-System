<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderReceivedController extends Controller
{
    public function __invoke(Order $order)
    {
        $order->update(['has_been_received_by_buyer' => true]);

        return back()->with(['success' => 'Order Received Successfully. We appreciate your cooperation. Kindly consider leaving a rating for the seller to support their selling efforts. Your feedback will greatly assist them.']);
    }
}