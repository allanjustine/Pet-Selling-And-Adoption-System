<?php 

namespace App\Services;

use App\Http\Requests\Order\BuyerOrderRequest;
use App\Models\Otp;
use App\Models\Order;
use App\Mail\OrderUpdate;
use Illuminate\Support\Facades\Mail;

class OrderService extends ImageUploadService 
{
    public function __construct(public OtpService $otp_service)
    {
        
    }

    public function storeOrder($user, BuyerOrderRequest $request)
    {
        $transaction_no = mt_rand(123456,999999);
        $order = '';

        $order = $user->orders()->create([
            'pet_id' => $request->pet_id,
            'contact' => $request->contact,
            'payment_method_id' => $request->payment_method_id,
            'reference_no' => $request->reference_no,
            'transaction_no' => $transaction_no,
            'note' => $request->note,
            'payment_type' => $request->payment_type,
        ]);
      
        $this->otp_service->clearOtp(); // clear otp

        return $this->handleImageUpload(model:$order, images: $request->image, collection:'payment_receipts', conversion_name:'card', action:'create');
    }

    /**
     * handle Order Status Update
     *
     * @param [type] $request
     * @param [type] $orders
     * @return void
     */
    public function handleOrder($request, $order)
    {
        $order->update([
            'status' => $request['status'],
            'remark' => $request['remark'],
        ]); // update order status


        // if the order status is delivered then mark the pet as not available


        if($order->status == Order::DELIVERED)
        {
            $order->pet()->update(['is_available' => false]);
        }

        $transaction_no = $order->transaction_no;

        $message = match ($request['status']) 
        {
            '1' => "Thank you for choosing Furfect! We're excited to inform you that your order with transaction no. $transaction_no has been approved. Connect with the pet owner to schedule a meet-up and bring home your new furry friend. Stay tuned for email and SMS updates on your request.",
            '2' => "Thank you for waiting. Unfortunatetly Furfect chooses to decline your order with transaction no. $transaction_no. 
            <br> Remark:' . $order->remark . '<br> Any Questions? You can visit our frequently asked question page or email us at app.furfect@gmail.com",
            '3' => "Thank you for choosing Furfect for your recent order. We are pleased to inform you that your order with transaction no. $transaction_no is now to be delivered",
            '4' => "Thank you for choosing Furfect for your recent order. We are pleased to inform you that your order with transaction no. $transaction_no has been successfully delivered. Please mark your recent order as order received.",
        };

        $route = route('buyer.orders.show', $order);

        return Mail::to($order->user->email)->send(new OrderUpdate($order->user->full_name, $message, $route));  // email user
    }
}