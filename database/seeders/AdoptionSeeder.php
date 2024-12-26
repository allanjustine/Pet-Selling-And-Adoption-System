<?php

namespace Database\Seeders;

use App\Models\Adoption;
use Illuminate\Database\Seeder;
use App\Services\ActivityLogsService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdoptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ActivityLogsService $service)
    {
        $adoptions = array(
            // User #2 > adoptions

            // Dog
            [
                'id' => 1,
                'user_id' => 2,
                'category_id' => 3,
                'breed_id' => 4,
                'pet_name' => 'Jacob',
                'sex' => 'male',
                'birth_date' => now()->subMonths(4),
                'color' => 'brown',
                'type' => 'cross breed',
                'reason' => 'wala na po magbabantay mag ma-migrate napo sa ibang bansa',
                'adopter_id' => null,
                'adopter_name' => null,
                'adopter_contact' => null,
                'is_adopted' => false,
                'status' => Adoption::PENDING,
                'created_at' => now()
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'category_id' => 3,
                'breed_id' => 7,
                'pet_name' => 'Jason',
                'sex' => 'male',
                'birth_date' => now()->subMonths(4),
                'color' => 'gray',
                'type' => 'cross breed',
                'reason' => 'wala na po magbabantay mag ma-migrate napo sa ibang bansa',
                'adopter_id' => null,
                'adopter_name' => null,
                'adopter_contact' => null,
                'is_adopted' => false,
                'status' => Adoption::APPROVED,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'category_id' => 3,
                'breed_id' => 1,
                'pet_name' => 'Alice',
                'sex' => 'female',
                'birth_date' => now()->subMonths(3),
                'color' => 'white',
                'type' => 'cross breed',
                'reason' => 'wala na po magbabantay mag ma-migrate napo sa ibang bansa',
                'adopter_id' => null,
                'adopter_name' => null,
                'adopter_contact' => null,
                'is_adopted' => false,
                'status' => Adoption::DECLINED,
                'created_at' => now()
            ],
            [
                'id' => 4,
                'user_id' => 2,
                'category_id' => 3,
                'breed_id' => 2,
                'pet_name' => 'Ash',
                'sex' => 'male',
                'birth_date' => now()->subMonths(3),
                'color' => 'brown',
                'type' => 'cross breed',
                'reason' => 'wala na po magbabantay mag ma-migrate napo sa ibang bansa',
                'adopter_id' => null,
                'adopter_name' => null,
                'adopter_contact' => null,
                'is_adopted' => false,
                'status' => Adoption::APPROVED,
                'created_at' => now()
            ],

            // User #3 > adoptions

            // dog
            [
                'id' => 5,
                'user_id' => 3,
                'category_id' => 3,
                'breed_id' => 4,
                'pet_name' => 'Dawson',
                'sex' => 'male',
                'birth_date' => now()->subMonths(3),
                'color' => 'brown',
                'type' => 'cross breed',
                'reason' => 'wala na po magbabantay mag ma-migrate napo sa ibang bansa',
                'adopter_id' => null,
                'adopter_name' => null,
                'adopter_contact' => null,
                'is_adopted' => false,
                'status' => Adoption::APPROVED,
                'created_at' => now()
            ],
            [
                'id' => 6,
                'user_id' => 3,
                'category_id' => 3,
                'breed_id' => 5,
                'pet_name' => 'Kobe',
                'sex' => 'male',
                'birth_date' => now()->subMonths(3),
                'color' => 'brown',
                'type' => 'cross breed',
                'reason' => 'wala na po magbabantay mag ma-migrate napo sa ibang bansa',
                'adopter_id' => null,
                'adopter_name' => null,
                'adopter_contact' => null,
                'is_adopted' => false,
                'status' => Adoption::APPROVED,
                'created_at' => now()
            ],

            // Cat
            [
                'id' => 7,
                'user_id' => 3,
                'category_id' => 2,
                'breed_id' => 7,
                'pet_name' => 'Mitch',
                'sex' => 'female',
                'birth_date' => now()->subMonths(3),
                'color' => 'brown',
                'type' => 'cross breed',
                'reason' => 'wala na po magbabantay mag ma-migrate napo sa ibang bansa',
                'adopter_id' => null,
                'adopter_name' => null,
                'adopter_contact' => null,
                'is_adopted' => false,
                'status' => Adoption::APPROVED,
                'created_at' => now()
            ],
            [
                'id' => 8,
                'user_id' => 3,
                'category_id' => 2,
                'breed_id' => 7,
                'pet_name' => 'Sally',
                'sex' => 'female',
                'birth_date' => now()->subMonths(3),
                'color' => 'black',
                'type' => 'cross breed',
                'reason' => 'wala na po magbabantay mag ma-migrate napo sa ibang bansa',
                'adopter_id' => null,
                'adopter_name' => "Jane Doe",
                'adopter_contact' => "09659312005",
                'is_adopted' => true,
                'status' => Adoption::APPROVED,
                'created_at' => now()
            ],

        );
 
        Adoption::insert($adoptions);

        Adoption::all()->each(function($adoption) use($service)
        {
            $adoption
            ->addMedia(public_path("/img/tmp_files/pet_adoption_avatars/$adoption->id.png"))
            ->preservingOriginal()
            ->toMediaCollection('avatar_image');

            $adoption
            ->addMedia(public_path("/img/tmp_files/proof_of_ownership/proof_of_ownership.jpg"))
            ->preservingOriginal()
            ->toMediaCollection('proof_of_ownership'); // attach proof of ownership

            $service->log_activity(model:$adoption, event:'added', model_name: 'Pet For Adoption', model_property_name: $adoption->pet_name, end_user: $adoption->user->full_name);

        });
    }
}