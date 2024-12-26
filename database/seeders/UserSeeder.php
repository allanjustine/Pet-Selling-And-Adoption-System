<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Services\ActivityLogsService;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ActivityLogsService $service)
    {
        $users = array(

            // generate sample admin
             [
                'id' => 1,
                'first_name' => 'Admin',
                'middle_name' => 'D',
                'last_name' => 'Admin',
                'sex' => 'male',
                'birth_date' => '1998-01-01',
                'address' => 'Sample Address',
                //'barangay_id' => mt_rand(1,3),
                'contact' => '09659312003',
                'email' => 'admin@gmail.com', 
                'password' => bcrypt('test1234'),
                'email_verified_at' => now(),
                'is_activated' => true, 
                'role_id' => Role::ADMIN,
                'created_at' => now()
             ],

             // generate sample seller
             [
                'id' => 2,
                'first_name' => 'Seller',
                'middle_name' => 'D',
                'last_name' => 'One',
                'sex' => 'male',
                'birth_date' => '1998-01-01',
                'address' => 'Sample Address',
                //'barangay_id' => mt_rand(1,3),
                'contact' => '09659312003',
                'email' => 'seller@gmail.com', 
                'password' => bcrypt('test1234'),
                'email_verified_at' => now(),
                'is_activated' => true, 
                'role_id' => Role::SELLER,
                'created_at' => now()
             ],
             [
                'id' => 3,
                'first_name' => 'Seller',
                'middle_name' => 'D',
                'last_name' => 'Two',
                'sex' => 'male',
                'birth_date' => '2001-01-01',
                'address' => 'Sample Address',
                //'barangay_id' => mt_rand(1,3),
                'contact' => '09353661095',
                'email' => 'seller_two@gmail.com', 
                'password' => bcrypt('test1234'),
                'email_verified_at' => now(),
                'is_activated' => true, 
                'role_id' => Role::SELLER,
                'created_at' => now()
             ],

             [
               'id' => 4,
               'first_name' => 'Dev',
               'middle_name' => 'D',
               'last_name' => 'Dev',
               'sex' => 'male',
               'birth_date' => '2001-01-01',
               'address' => 'Sample Address',
               //'barangay_id' => mt_rand(1,3),
               'contact' => '09353661095',
               'email' => 'buyer@gmail.com', 
               'password' => bcrypt('test1234'),
               'email_verified_at' => now(),
               'is_activated' => true, 
               'role_id' => Role::BUYER,
               'created_at' => now()
            ],

             [
                'id' => 5,
                'first_name' => 'Jayson',
                'middle_name' => 'D',
                'last_name' => 'Lajarca',
                'sex' => 'male',
                'birth_date' => '2001-01-01',
                'address' => 'Sample Address',
                //'barangay_id' => mt_rand(1,3),
                'contact' => '09353661095',
                'email' => 'lajarcajayson@gmail.com', 
                'password' => bcrypt('test1234'),
                'email_verified_at' => now(),
                'is_activated' => true, 
                'role_id' => Role::BUYER,
                'created_at' => now()
             ],
             
          );
 
          User::insert($users);

          User::all()->each(function($user) use($service){
            $user
            ->addMedia(public_path("/img/tmp_files/avatars/$user->id.png"))
            ->preservingOriginal()
            ->toMediaCollection('avatar_image');

            $service->log_activity(model:new User(), event:'added', model_name: 'User', model_property_name: $user->name ?? 'Admin');

        });
    }
}