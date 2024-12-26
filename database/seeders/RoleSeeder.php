<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $roles = array(
           ['id' => 1, 'name' => 'admin', 'created_at' => now()],
           ['id' => 2, 'name' => 'seller', 'created_at' => now()],
           ['id' => 3, 'name' => 'buyer', 'created_at' => now()],
       );

       Role::insert($roles);
    }
}