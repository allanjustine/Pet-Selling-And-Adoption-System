<?php

namespace Database\Seeders;

use App\Models\SellerAccount;
use Illuminate\Database\Seeder;
use App\Services\ActivityLogsService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SellerAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ActivityLogsService $service)
    {
        $seller_accounts = array(

            // User #2 > Seller Account
             [
                'id' => 1,
                'user_id' => 2,
                'business_name' => 'ABC PetShop',
                'contact' => '09659312005',
                'email' => 'abc.petshop@gmail.com',
                'address' => '156 Dr. Pilapil St. San Miguel, Pasig City', 
                'status' => SellerAccount::APPROVED,
                'remark' => null,
                'created_at' => now()
             ],
             [
                'id' => 2,
                'user_id' => 3,
                'business_name' => 'XYZ PetShop',
                'contact' => '09659312005',
                'email' => 'xyz.petshop@gmail.com',
                'address' => '158 Dr. Pilapil St. San Miguel, Pasig City',
                'status' => SellerAccount::APPROVED, 
                'remark' => null,
                'created_at' => now()
             ],
          );
 
          SellerAccount::insert($seller_accounts);


          SellerAccount::all()->each(function($seller_account) use($service)
          {
  
              $seller_account
              ->addMedia(public_path("/img/tmp_files/seller/$seller_account->id.jpg"))
              ->preservingOriginal()
              ->toMediaCollection('proof_of_ownership'); // attach proof of ownership
  
              $service->log_activity(model:$seller_account, event:'added', model_name: 'Seller Account', model_property_name: $seller_account->business_name, end_user: $seller_account->user->full_name);
  
          });
    }
}