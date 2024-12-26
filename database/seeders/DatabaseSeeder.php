<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Run Seeders
       
        $this->call([

            /** Start User Management*/ 
                BarangaySeeder::class,
                RoleSeeder::class,
                UserSeeder::class,
                SellerAccountSeeder::class,
            /** End User Management*/ 
          
            /** Start Pet Management*/ 
                CategorySeeder::class,
                BreedSeeder::class,
                PetSeeder::class,
            /** End Pet Management*/ 

            /** Start Order Management*/ 
                PaymentMethodSeeder::class,
                OrderSeeder::class,
            /** End Order Management*/ 

                AdoptionSeeder::class,
                RatingSeeder::class,
        ]);

    }
}