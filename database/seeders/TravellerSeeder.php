<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
use App\Models\Traveller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class TravellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if we have any trips
        if (Trip::count() == 0) {
            $this->command->info('No trips found. Make sure CreateTripsSeeder has been run.');
            return;
        }

        // Check the structure of the travellers table
        $travellersColumns = Schema::getColumnListing('travellers');
        $this->command->info('Available columns in travellers table: ' . implode(', ', $travellersColumns));

        // Check the structure of the users table
        $usersColumns = Schema::getColumnListing('users');
        $this->command->info('Available columns in users table: ' . implode(', ', $usersColumns));

        // Sample traveller data
        $travellers = [
            [
                'login' => 'r0933332',
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
            [
                'login' => 'r0900000',
                'first_name' => 'Marie',
                'last_name' => 'Dupont',
                'email' => 'bierenssander@gmail.com',
                'gender' => 'Vrouw',
                'nationality' => 'Belg',
                'birthdate' => '1999-08-23',
                'birthplace' => 'Brussel',
                'address' => 'Tiensestraat 45',
                'city' => 'Leuven',
                'country' => 'België',
                'phone' => '+32478901234',
                'emergency_phone_1' => '+32455678901',
                'emergency_phone_2' => '+32466543210',
                'education_id' => 2,
                'major_id' => 4,
                'medical_info' => 'Lactose-intolerant',
                'medical_issue' => 1,
                'zip_id' => '3000',
                'iban' => 'BE71096123456769',
                'bic' => 'GEBABEBB',
            ],
        ];

        foreach ($travellers as $travellerData) {
            try {
                // Prepare user data based on actual table columns
                $userData = [
                    'login' => $travellerData['login'],
                    'password' => Hash::make('password123'),
                    'role' => 'traveller',
                ];

                // Find or create user
                $existingUser = User::where('login', $travellerData['login'])->first();

                if ($existingUser) {
                    $user = $existingUser;
                    $this->command->info("User {$travellerData['login']} already exists, using existing user.");
                } else {
                    $user = User::create($userData);
                    $this->command->info("Created new user: {$travellerData['login']}");
                }

                // Check if traveller record already exists
                $existingTraveller = Traveller::where('user_id', $user->id)->first();
                if ($existingTraveller) {
                    $this->command->info("Traveller for user {$travellerData['login']} already exists, skipping...");
                    continue;
                }

                // Use direct DB insertion with only the fields that exist in the table
                $insertData = [
                    'user_id' => $user->id,
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
                $this->command->info("Created traveller: {$travellerData['first_name']} {$travellerData['last_name']}");
            } catch (\Exception $e) {
                $this->command->error("Error creating traveller {$travellerData['login']}: " . $e->getMessage());
                // Print detailed trace for debugging
                $this->command->line("Stack trace: " . $e->getTraceAsString());
            }
        }
    }
}
