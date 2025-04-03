<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Traveller;
use Illuminate\Support\Facades\DB;

class CreateTravellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the user with login r0933332
        $user = User::where('login', 'r0933332')->first();

        // If user doesn't exist, we can't create a traveller record
        if (!$user) {
            $this->command->error('User with login r0933332 not found. Skipping traveller creation.');
            return;
        }

        // Check if traveller already exists for this user
        $existingTraveller = DB::table('travellers')->where('user_id', $user->id)->first();
        if ($existingTraveller) {
            $this->command->info('Traveller record for user r0933332 already exists.');
            return;
        }

        // Insert traveller record
        DB::table('travellers')->insert([
            'user_id' => $user->id,
            'zip_id' => '3020',
            'major_id' => 1,
            'first_name' => 'Sander',
            'last_name' => 'Bierens',
            'email' => 'r0933332@ucll.be',
            'country' => 'Belgium',
            'address' => 'Haachtstraat 123',
            'gender' => 'Man',
            'phone' => '+32496994042',
            'emergency_phone_1' => '+32470123456',
            'emergency_phone_2' => '+32470654321',
            'nationality' => 'Belg',
            'birthdate' => '2000-01-15',
            'birthplace' => 'Leuven',
            'iban' => 'BE68539007547034',
            'bic' => 'GEBABEBB',
            'medical_issue' => 0,
            'medical_info' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Traveller record created successfully for user r0933332.');
    }
}
