<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateEducationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educations = [
            ['name' => 'Elektronica - ICT'],
            ['name' => 'Elektromechanica'],
            ['name' => 'Energietechnologie'],
            ['name' => 'Chemie'],
        ];

        foreach ($educations as $education) {
            Education::create($education);
        }
    }
}
