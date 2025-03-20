<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'login' => 'Admin',
                'role' => 'admin',
                'password' => bcrypt('admin'),
            ],
            [
                'login' => 'Traveller',
                'role' => 'traveller',
                'password' => bcrypt('traveller'),
            ],
            [
                'login' => 'Guide',
                'role' => 'guide',
                'password' => bcrypt('guide'),
            ],
            [
                'login' => 'Guest',
                'role' => 'guest',
                'password' => bcrypt('guest'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
