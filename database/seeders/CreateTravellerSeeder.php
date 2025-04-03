<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
use App\Models\Traveller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateTravellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample traveller data
        $data = [
            [
                'login' => 'r0933332',
                'trip_id' => 1,
                'first_name' => 'Jan',
                'last_name' => 'Janssens',
                'email' => 'r0933332@ucll.be',
                'gender' => 'Man',
                'nationality' => 'Belg',
                'birthdate' => '1998-05-12',
                'birthplace' => 'Leuven',
                'address' => 'Bondgenotenlaan 120',
                'city' => 'Leuven',
                'country' => 'België',
                'phone' => '+32496123456',
                'emergency_phone_1' => '+32471234567',
                'emergency_phone_2' => '+32487654321',
                'education_id' => 1,
                'major_id' => 1,
                'medical_info' => 'Geen bijzonderheden',
                'medical_issue' => 0,
                'zip_id' => '3000',
                'iban' => 'BE68539007547034',
                'bic' => 'GEBABEBB',
            ],
        ];

        foreach ($data as $travellerData) {
              // Prepare user data based on actual table columns
                $userData = [
                'login' => $travellerData['login'],
                'password' => Hash::make('password123'),
                'role' => 'traveller',
            ];
            
            // Use updateOrCreate to either find the user or create it if it doesn't exist
            $user = User::updateOrCreate(
                ['login' => $travellerData['login']],
                $userData
            );

            // Use direct DB insertion with only the fields that exist in the table
            $insertData = [
                'user_id' => $user->id,
                'trip_id' => $travellerData['trip_id'], 
                'zip_id' => $travellerData['zip_id'],
                'major_id' => $travellerData['major_id'],
                'first_name' => $travellerData['first_name'],
                'last_name' => $travellerData['last_name'],
                'email' => $travellerData['email'],
                'country' => $travellerData['country'],
                'address' => $travellerData['address'],
                'gender' => $travellerData['gender'],
                'phone' => $travellerData['phone'],
                'emergency_phone_1' => $travellerData['emergency_phone_1'],
                'emergency_phone_2' => $travellerData['emergency_phone_2'],
                'nationality' => $travellerData['nationality'],
                'birthdate' => $travellerData['birthdate'],
                'birthplace' => $travellerData['birthplace'],
                'iban' => $travellerData['iban'],
                'bic' => $travellerData['bic'],
                'medical_issue' => $travellerData['medical_issue'],
                'medical_info' => $travellerData['medical_info'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('travellers')->insert($insertData);
        }
    }
}
