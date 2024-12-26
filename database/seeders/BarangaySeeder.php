<?php

namespace Database\Seeders;

use App\Models\Barangay;
use Illuminate\Database\Seeder;
use App\Services\ActivityLogsService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ActivityLogsService $service)
    {
        $barangays = array(
            ['id' => 1, 'name' => 'Barangay A', 'created_at' => now()],
            ['id' => 2, 'name' => 'Barangay B', 'created_at' => now()],
            ['id' => 3, 'name' => 'Barangay C', 'created_at' => now()],
            ['id' => 4, 'name' => 'Barangay D', 'created_at' => now()],
            ['id' => 5, 'name' => 'Barangay E', 'created_at' => now()],
        );

        Barangay::insert($barangays);

        Barangay::all()->each(fn(
            $barangay) => $service->log_activity(model:$barangay, event:'added', model_name: 'Barangay', model_property_name: $barangay->name)
        );

    }
}