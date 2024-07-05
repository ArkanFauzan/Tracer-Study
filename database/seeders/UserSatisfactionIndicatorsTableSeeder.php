<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
USE Illuminate\Support\Str;

class UserSatisfactionIndicatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the data already exists
        $count = DB::table('user_satisfaction_indicators')->count();

        if ($count === 0) {
            // Insert seeder sequence (from parent)
            $this->seedIndicator();
            $this->command->info('User satisfaction indicator seeded successfully.');
        }
        else {
            $this->command->info('User satisfaction indicator already seeded.');
        }
    }

    private function seedIndicator() {
        $data = [
            'Etika',
            'Keahlian pada bidang ilmu (kompetensi utama)',
            'Kemampuan bahasa asing',
            'Penggunaan teknologi informasi',
            'Kemampuan berkomunikasi',
            'Kerjasama',
            'Pengembangan diri'
        ];

        $time = time();
        $dataToInsert = [];
        foreach ($data as $val) {
            $dataToInsert[] = [
                'id' => (string) Str::uuid(),
                'name' => $val,
                'created_at' => date('Y-m-d H:i:s', $time)
            ];
            $time++; // for sort by created_at
        }

        DB::table('user_satisfaction_indicators')->insert($dataToInsert);
    }
}
