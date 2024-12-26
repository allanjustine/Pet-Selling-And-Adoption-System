<?php

namespace App\Http\Controllers\Seller;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MarkAsDelivered\MarkAsDeliveredRequest;
use App\Services\ImageUploadService;

class MarkAsDeliveredController extends Controller
{
    public function __invoke(MarkAsDeliveredRequest $request, Order $order, ImageUploadService $service)
    {
        $order->update([
            'has_been_delivered_by_seller' => true
        ]);

        if($request->image)
        {
            $service->handleImageUpload(model:$order, images: $request->image, collection:'proof_of_deliveries', conversion_name:'card', action:'create');
        }

        return back()->with(['success' => 'Congratulations on marking your order as delivered! We would like to inform you that you will soon receive an email or SMS update regarding your earnings. Stay tuned for the detailed information on your earnings and further instructions on accessing them.' ]);
    }
}