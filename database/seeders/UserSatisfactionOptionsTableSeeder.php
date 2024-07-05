<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
USE Illuminate\Support\Str;

class UserSatisfactionOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the data already exists
        $count = DB::table('user_satisfaction_options')->count();

        if ($count === 0) {
            // Insert seeder sequence (from parent)
            $this->seedOption();
            $this->command->info('User satisfaction option seeded successfully.');
        }
        else {
            $this->command->info('User satisfaction option already seeded.');
        }
    }

    private function seedOption() {
        $data = [
            'Sangat Tinggi',
            'Tinggi',
            'Cukup Tinggi',
            'Rendah',
            'Sangat Rendah'
        ];

        $time = time();
        $dataToInsert = [];
        foreach ($data as $val) {
            $dataToInsert[] = [
                'id' => (string) Str::uuid(),
                'option' => $val,
                'created_at' => date('Y-m-d H:i:s', $time)
            ];
            $time++; // for sort by created_at
        }

        DB::table('user_satisfaction_options')->insert($dataToInsert);
    }
}
