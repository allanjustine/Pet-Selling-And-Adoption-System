<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\AdditionalPayment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdditionalPaymentUpdate;
use App\Http\Requests\AdditionalPayment\AdminAdditionalPaymentRequest;

class AdditionalPaymentController extends Controller
{
    public function __invoke(AdminAdditionalPaymentRequest $request, Order $order, AdditionalPayment $additional_payment)
    {
        $additional_payment->update([
            'status' => $request['status'],
            'remark' => $request['remark'],
        ]); // update order status

        $transaction_no = $additional_payment->transaction_no;

        $message = match ($request['status']) 
        {
            '1' => "Thank you for choosing Furfect! We're excited to inform you that your payment with transaction no. $transaction_no has been approved. Connect with the pet owner to schedule a meet-up and bring home your new furry friend. Stay tuned for email and SMS updates on your request.",
            '2' => "Thank you for waiting. Unfortunatetly Furfect chooses to decline your payment with transaction no. $transaction_no. 
            <br> Remark:' . $additional_payment->remark . '<br> Any Questions? You can visit our frequently asked question page or email us at app.furfect@gmail.com",
        };

        $route = route('buyer.orders.show', $order);

        Mail::to($additional_payment->user->email)->send(new AdditionalPaymentUpdate($additional_payment->user->full_name, $message, $route));  // email buyer

        return back()->with(['success' => "Order Additional Payment Status Updated Successfully"]);
    }
}