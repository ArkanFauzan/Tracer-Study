<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
USE Illuminate\Support\Str;

class MajorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if the data already exists
        $count = DB::table('majors')->count();

        if ($count === 0) {
            // Insert seeder sequence (from parent)

            $this->seedMajorType();
            $this->command->info('Major type seeded successfully.');

            $this->seedMajor();
            $this->command->info('Major seeded successfully.');
        }
        else {
            $this->command->info('Major already seeded.');
        }
    }

    private function seedMajorType() {

        $time = time();
        $data = [
            [
                'id' => 'dadfff6f-f8e3-4d6c-a9f2-3c40d09ed5a3',
                'name' => 'D3',
                'created_at' => date('Y-m-d H:i:s', $time)
            ],
            [
                'id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'name' => 'S1',
                'created_at' => date('Y-m-d H:i:s', $time + 1)
            ],
            [
                'id' => '3462df33-7c70-4891-a2b6-44874afab316',
                'name' => 'S2',
                'created_at' => date('Y-m-d H:i:s', $time + 2)
            ],
        ];

        DB::table('major_types')->insert($data);
    }

    private function seedMajor() {

        $data = [
            [
                'id' => (string) Str::uuid(),
                'name' => 'TEKNIK INFORMATIKA',
                'major_type_id' => 'dadfff6f-f8e3-4d6c-a9f2-3c40d09ed5a3',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'AKUNTANSI',
                'major_type_id' => 'dadfff6f-f8e3-4d6c-a9f2-3c40d09ed5a3',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'KEUANGAN DAN PERBANKAN',
                'major_type_id' => 'dadfff6f-f8e3-4d6c-a9f2-3c40d09ed5a3',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'TEKNIK INFORMATIKA',
                'major_type_id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'TEKNIK SIPIL',
                'major_type_id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'TEKNIK INDUSTRI',
                'major_type_id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'TEKNIK MESIN',
                'major_type_id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'SISTEM INFORMASI',
                'major_type_id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'TEKNIK ELEKTRO',
                'major_type_id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'ILMU KOMUNIKASI',
                'major_type_id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'ADMINISTRASI NIAGA',
                'major_type_id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'MANAJAMEN',
                'major_type_id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'AKUNTANSI',
                'major_type_id' => 'a1ea26aa-46cd-4e69-aaa0-f852597a3edf',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'MAGISTER TEKNIK',
                'major_type_id' => '3462df33-7c70-4891-a2b6-44874afab316',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'MAGISTER MANAJEMEN',
                'major_type_id' => '3462df33-7c70-4891-a2b6-44874afab316',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'MAGISTER AKUNTANSI',
                'major_type_id' => '3462df33-7c70-4891-a2b6-44874afab316',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        DB::table('majors')->insert($data);
    }
}
