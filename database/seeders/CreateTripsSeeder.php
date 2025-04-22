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
            ['name' => 'Spanje', 'contact_email' => 'techreizen@gmail.com'],
            ['name' => 'Zwitserland', 'contact_email' => 'techreizen@gmail.com',],
            ['name' => 'Frankrijk', 'contact_email' => 'techreizen@gmail.com',],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }
    }
}
