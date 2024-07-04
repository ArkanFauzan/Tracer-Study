<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the specific user to seed
        $specificUser = [
            'id' => '68f5df87-9bf2-4388-bdeb-0201108aa6a8',
            'name' => env('DEFAULT_ADMIN_NAME', 'Admin'),
            'email' => env('DEFAULT_ADMIN_EMAIL', 'admin@example.com'),
            'password' => Hash::make(env('DEFAULT_ADMIN_PASSWORD', 'password123')),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Check if the specific user already exists
        $existingUser = DB::table('users')->where('id', $specificUser['id'])->first();

        if ($existingUser === null) {
            // Insert the specific user into the database
            DB::table('users')->insert($specificUser);
            $this->command->info('Specific user seeded successfully.');
        } else {
            $this->command->info('Specific user already exists.');
        }
    }
}
