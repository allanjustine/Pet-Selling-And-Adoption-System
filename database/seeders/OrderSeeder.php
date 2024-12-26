<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use App\Services\ActivityLogsService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ActivityLogsService $service)
    {
        $orders = array(
            [
                'id' => 1,
                'user_id' => 4,
                'pet_id' => 1,
                'payment_method_id' =>  1,
                'transaction_no' => '548182115',
                'reference_no' => '1000312111',
                'contact' => '09659312005',
                'note' => null,
                'status' => Order::DELIVERED,
                'remark' => null,
                'payment_type' => 'full',
                'created_at' => now(),
                'has_been_received_by_buyer' => true,
                'has_been_delivered_by_seller' => true,
                
            ],
            [
                'id' => 2,
                'user_id' => 4,
                'pet_id' => 2,
                'payment_method_id' =>  1,
                'transaction_no' => '5481821156',
                'reference_no' => '10003121112',
                'contact' => '09659312005',
                'note' => null,
                'status' => Order::DELIVERED,
                'remark' => null,
                'payment_type' => 'full',
                'created_at' => now()->subMonth(),
                'has_been_received_by_buyer' => true,
                'has_been_delivered_by_seller' => true,
            ],
            [
                'id' => 3,
                'user_id' => 4,
                'pet_id' => 3,
                'payment_method_id' =>  1,
                'transaction_no' => '5481821157',
                'reference_no' => '10003121113',
                'contact' => '09659312005',
                'note' => null,
                'status' => Order::DELIVERED,
                'remark' => null,
                'payment_type' => 'full',
                'created_at' => now()->subMonth(),
                'has_been_received_by_buyer' => true,
                'has_been_delivered_by_seller' => true,
            ],
            [
                'id' => 4,
                'user_id' => 4,
                'pet_id' => 4,
                'payment_method_id' =>  1,
                'transaction_no' => '548182118',
                'reference_no' => '1000312114',
                'contact' => '09659312005',
                'note' => null,
                'status' => Order::PENDING,
                'remark' => null,
                'payment_type' => 'full',
                'created_at' => now()->subHour(),
                'has_been_received_by_buyer' => false,
                'has_been_delivered_by_seller' => false,
            ],
        );

        Order::insert($orders);

        Order::all()->each(function($order) use($service) {
            
            $order->addMedia(public_path("/img/tmp_files/gcash.png"))->preservingOriginal()->toMediaCollection('payment_receipts');

            if($order->status == Order::DELIVERED)
            {
                $order->addMedia(public_path("/img/tmp_files/proof_of_delivery/proof_of_delivery.png"))->preservingOriginal()->toMediaCollection('proof_of_deliveries');
            }

            $service->log_activity(model:$order, event:'requested', model_name: 'Order', model_property_name: $order->transaction_no, conjunction:'an', end_user: $order->user->full_name);
        });
    }
}