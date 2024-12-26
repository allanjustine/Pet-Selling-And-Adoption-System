<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdditionalPayment\BuyerAdditionalPaymentRequest;
use App\Models\AdditionalPayment;
use App\Services\ImageUploadService;
use App\Services\OtpService;

class AdditionalPaymentController extends Controller
{
    public function create(Order $order)
    {
        return view('buyer.additional_payment.create', [
            'order' => $order->load(['pet' => fn($query) => $query->with('media', 'category', 'breed'), 'user.barangay']),
            'payment_methods' => PaymentMethod::all(),
        ]);
    }

    public function store(BuyerAdditionalPaymentRequest $request, Order $order, ImageUploadService $image_upload_service, OtpService $otp_service)
    {
         //check if the otp is correct
         if (!$otp_service->checkOtp($request->otp)) {
            
            $otp_service->clearOtp(); // empty otp

            return back()->with(['error' => 'Invalid OTP Code']);
        }

        $transaction_no = mt_rand(123456,999999);

        $additional_payment = auth()->user()->additional_payments()->create([
            'order_id' => $order->id,
            'payment_method_id' => $request->payment_method_id,
            'reference_no' => $request->reference_no,
            'transaction_no' => $transaction_no,
        ]);
      
        $otp_service->clearOtp(); // clear otp

        $image_upload_service->handleImageUpload(model:$additional_payment, images: $request->image, collection:'payment_receipts', conversion_name:'card', action:'create');

        return to_route('buyer.orders.show', $order)->with([
            'success' => "
            Thank you for submitting your payment! We are delighted to have you as our valued customer and want to assure you that we are taking good care of your order.\n
            In a short while, you will receive an email and an SMS with updates about the progress of your purchase. These notifications will contain all the necessary information regarding your order.
            "
        ]);
    }

    public function show(AdditionalPayment $additional_payment)
    {
        return view('buyer.additional_payment.show', [
            'additional_payment' => $additional_payment->load('order', 'media', 'payment_method'),
        ]);
    }
}