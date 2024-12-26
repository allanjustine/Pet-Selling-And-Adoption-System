<?php

namespace Database\Seeders;

use App\Models\Pet;
use Illuminate\Database\Seeder;
use App\Services\ActivityLogsService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ActivityLogsService $service)
    {
        $pets = array(
            // User #2 > Pets

            // Dog
            [
                'id' => 1,
                'user_id' => 2,
                'category_id' => 3,
                'breed_id' => 3,
                'name' => 'Bullet',
                'sex' => 'male',
                'birth_date' => now()->subMonths(4),
                'color' => 'brown',
                'vaccine_taken' => '4 in 1',
                'price' => 5000.00,
                'type' => 'pure breed',
                'notes' => "Meet our lovable pet! This charming companion, who's been nurtured with care, is now ready to bring endless happiness to your life. With a balanced diet and regular vitamins, they are not just a pet but a healthy bundle of joy waiting to become a cherished member of your family. Don't miss the chance to make them a part of your family today!",
                'is_available' => false,
                'status' => Pet::APPROVED,
                'created_at' => now()
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'category_id' => 3,
                'breed_id' => 4,
                'name' => 'John Wick',
                'sex' => 'male',
                'birth_date' => now()->subMonths(4),
                'color' => 'gray',
                'vaccine_taken' => '5 in 1',
                'price' => 15000.00,
                'type' => 'pure breed',
                'notes' => "Discover your new best friend! Our delightful pet, thoughtfully nurtured with a regimen of essential vitamins, is ready to fill your life with joy and companionship. Bring them home today!",
                'is_available' => false,
                'status' => Pet::APPROVED,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'category_id' => 3,
                'breed_id' => 2,
                'name' => 'Madz',
                'sex' => 'female',
                'birth_date' => now()->subMonths(3),
                'color' => 'white',
                'vaccine_taken' => '5 in 1',
                'price' => 3000.00,
                'type' => 'pure breed',
                'notes' => "Looking for a furry family member? Our charming pet, raised with love and a healthy dose of vitamins, is eager to become your loyal companion. Don't wait; make them a part of your life now!",
                'is_available' => false,
                'status' => Pet::APPROVED,
                'created_at' => now()
            ],
            [
                'id' => 4,
                'user_id' => 2,
                'category_id' => 3,
                'breed_id' => 5,
                'name' => 'Josh',
                'sex' => 'male',
                'birth_date' => now()->subMonths(3),
                'color' => 'brown',
                'vaccine_taken' => '5 in 1',
                'price' => 15000.00,
                'type' => 'pure breed',
                'notes' => "Meet our wonderful pet – a true bundle of joy! They've enjoyed a balanced diet and received all the necessary vitamins for a happy and healthy life. Make your home complete with their boundless love!",
                'is_available' => true,
                'status' => Pet::APPROVED,
                'created_at' => now()
            ],

            // User #3 > Pets

            // dog
            [
                'id' => 5,
                'user_id' => 3,
                'category_id' => 3,
                'breed_id' => 6,
                'name' => 'Mark',
                'sex' => 'male',
                'birth_date' => now()->subMonths(3),
                'color' => 'brown',
                'vaccine_taken' => '5 in 1',
                'price' => 20000.00,
                'type' => 'pure breed',
                'notes' => "Your perfect pet awaits! Our lovable companion, well-cared for and supplemented with vitamins, is ready to share a lifetime of love and laughter with your family. Make the choice that fills your heart today!",
                'is_available' => true,
                'status' => Pet::APPROVED,
                'created_at' => now()
            ],
            [
                'id' => 6,
                'user_id' => 3,
                'category_id' => 3,
                'breed_id' => 7,
                'name' => 'Jacob',
                'sex' => 'male',
                'birth_date' => now()->subMonths(3),
                'color' => 'brown',
                'vaccine_taken' => '5 in 1',
                'price' => 10000.00,
                'type' => 'pure breed',
                'notes' => "Ready for a heartwarming addition to your home? Our cherished pet, nurtured with care and fortified with essential vitamins, is prepared to bring endless happiness to your life. Welcome them into your family now!",
                'is_available' => true,
                'status' => Pet::APPROVED,
                'created_at' => now()
            ],

            // Cat
            [
                'id' => 7,
                'user_id' => 3,
                'category_id' => 2,
                'breed_id' => 8,
                'name' => 'Joana',
                'sex' => 'female',
                'birth_date' => now()->subMonths(3),
                'color' => 'brown',
                'vaccine_taken' => null,
                'price' => 8000.00,
                'type' => 'pure breed',
                'notes' => null,
                'is_available' => true,
                'status' => Pet::APPROVED,
                'created_at' => now()
            ],
            [
                'id' => 8,
                'user_id' => 3,
                'category_id' => 2,
                'breed_id' => 9,
                'name' => 'Aztec',
                'sex' => 'female',
                'birth_date' => now()->subMonths(3),
                'color' => 'black',
                'vaccine_taken' => null,
                'price' => 9000.00,
                'type' => 'pure breed',
                'notes' => null,
                'is_available' => true,
                'status' => Pet::APPROVED,
                'created_at' => now()
            ],


            // User #4 > Pets

            // dogs
            [
                'id' => 9,
                'user_id' => 2,
                'category_id' => 3,
                'breed_id' => 3,
                'name' => 'Bravo',
                'sex' => 'male',
                'birth_date' => now()->subMonths(3),
                'color' => 'black',
                'vaccine_taken' => null,
                'price' => 9000.00,
                'type' => 'pure breed',
                'notes' => null,
                'is_available' => true,
                'status' => Pet::APPROVED,
                'created_at' => now()
            ],
            [
                'id' => 10,
                'user_id' => 2,
                'category_id' => 3,
                'breed_id' => 1,
                'name' => 'Bravo',
                'sex' => 'male',
                'birth_date' => now()->subMonths(3),
                'color' => 'black',
                'vaccine_taken' => null,
                'price' => 9000.00,
                'type' => 'pure breed',
                'notes' => null,
                'is_available' => true,
                'status' => Pet::APPROVED,
                'created_at' => now()
            ],

        );
 
        Pet::insert($pets);

        Pet::all()->each(function($pet) use($service)
        {
            $pet
            ->addMedia(public_path("/img/tmp_files/pet_avatars/$pet->id.png"))
            ->preservingOriginal()
            ->toMediaCollection('avatar_image');

            $pet
            ->addMedia(public_path("/img/tmp_files/proof_of_ownership/proof_of_ownership.jpg"))
            ->preservingOriginal()
            ->toMediaCollection('proof_of_ownership'); // attach proof of ownership

            $service->log_activity(model:$pet, event:'added', model_name: 'Pet', model_property_name: $pet->name, end_user: $pet->user->full_name);

        });
    }
}