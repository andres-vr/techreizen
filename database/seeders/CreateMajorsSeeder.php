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
            ['name' => 'Elektronica', 'education_id' => '1',],
            ['name' => 'ICT', 'education_id' => '1',],
            ['name' => 'Elektromechanica', 'education_id' => '2',],
            ['name' => 'Automatisering', 'education_id' => '2',],
            ['name' => 'Klimatisering', 'education_id' => '2',],
            ['name' => 'Onderhoudstechnologie', 'education_id' => '2',],
            ['name' => 'Energietechnologie', 'education_id' => '3',],
            ['name' => 'Chemie', 'education_id' => '4',],
            ['name' => 'Biochemie', 'education_id' => '4',],
            ['name' => 'Milieutechnologie', 'education_id' => '4',],
            ['name' => 'Procestechnologie', 'education_id' => '4',],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}
