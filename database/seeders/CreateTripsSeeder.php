<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;

class CreateTripsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trips = [
            ['name' => 'Duitsland-Tsjechië 2025', 'contact_email' => 'techreizen@gmail.com', 'countries' => ['Duitsland', 'Tsjechië']],
            ['name' => 'Italië 2025', 'contact_email' => 'techreizen@gmail.com', 'countries' => ['Italië']],
            ['name' => 'Oostenrijk-Zwitserland 2026', 'contact_email' => 'techreizen@gmail.com', 'countries' => ['Oostenrijk', 'Zwitserland']],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }
    }
}
