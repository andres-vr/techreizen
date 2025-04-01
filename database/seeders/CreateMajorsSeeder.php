<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateMajorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            [
                'name' => 'ELO',
                'education_id' => '1',
            ],
            [
                'name' => 'ICT',
                'education_id' => '1',
            ],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}
