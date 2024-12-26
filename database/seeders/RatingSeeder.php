<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratings = array(

            // dev rated seller# 1
            [
                'order_id' => 1,
                'sender_id' => 4,
                'receiver_id' => 2,
                'rating' => 5,
                'comment' => 'smooth transaction',
                'created_at' => now(),
            ],
            [
                'order_id' => 1,
                'sender_id' => 5,
                'receiver_id' => 2,
                'rating' => 5,
                'comment' => 'good transaction',
                'created_at' => now(),
            ],

            // dev rated seller# 2
            [
                'order_id' => 1,
                'sender_id' => 4,
                'receiver_id' => 3,
                'rating' => 2,
                'comment' => 'good transaction',
                'created_at' => now(),
            ],
        );

        Rating::insert($ratings);
    }
}