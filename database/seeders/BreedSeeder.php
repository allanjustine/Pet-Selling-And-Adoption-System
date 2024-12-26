<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Seeder;
use App\Services\ActivityLogsService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ActivityLogsService $service)
    {
        $breeds = array(

            //  Dog > Breeds

            ['id' => 1,'category_id' => 3, 'name' => 'Golden Retriever', 'created_at' => now()],
            ['id' => 2,'category_id' => 3, 'name' => 'Shih Tzu', 'created_at' => now()],
            ['id' => 3,'category_id' => 3, 'name' => 'Dachshund', 'created_at' => now()],
            ['id' => 4,'category_id' => 3, 'name' => 'Americal Bully', 'created_at' => now()],
            ['id' => 5,'category_id' => 3, 'name' => 'Pug', 'created_at' => now()],
            ['id' => 6,'category_id' => 3, 'name' => 'French Bulldog', 'created_at' => now()],
            ['id' => 7,'category_id' => 3, 'name' => 'Beagle', 'created_at' => now()],

            // Cat > Breeds
            ['id' => 8,'category_id' => 2, 'name' => 'Siamese', 'created_at' => now()],
            ['id' => 9,'category_id' => 2, 'name' => 'Persian', 'created_at' => now()],

            // Bird > Breeds
            ['id' => 10,'category_id' => 1, 'name' => 'Parakeets', 'created_at' => now()],
            ['id' => 11,'category_id' => 1, 'name' => 'Dove', 'created_at' => now()],

            // Fish > Breeds
            ['id' => 12,'category_id' => 4, 'name' => 'Gold Fish', 'created_at' => now()],
            ['id' => 13,'category_id' => 4, 'name' => 'Betta Fish', 'created_at' => now()],

            // Others > Breeds

            ['id' => 14,'category_id' => 5, 'name' => 'No Breed', 'created_at' => now()],

        );

        Breed::insert($breeds);

        Breed::all()->each(fn(
            $breed) => $service->log_activity(model:$breed, event:'added', model_name: 'Breed', model_property_name: $breed->name)
        );
    }
}