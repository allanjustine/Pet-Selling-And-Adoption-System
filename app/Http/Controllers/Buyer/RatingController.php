<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    public function __invoke(Request $request)
    {
        $data =   $request->validate([
            'order_id' => 'required',
            'receiver_id' => 'required',
            'rating' => 'required',
            'comment' => 'required',
        ]);

        $rating = Rating::create($data + ['sender_id' => auth()->id()]);

        $this->log_activity(model: $rating, event: 'rated', model_name: 'User', model_property_name: $rating->receiver->name);  // logs

        return back()->with(['success' => 'Thank you for your feedback. Your rating has been submitted successfully']);
    }
}