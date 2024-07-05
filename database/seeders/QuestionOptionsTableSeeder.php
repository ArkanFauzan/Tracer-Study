<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
USE Illuminate\Support\Str;

class QuestionOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the specific user already exists
        $count = DB::table('question_options')->count();

        if ($count === 0) {
            // Insert seeder sequence (from parent)

            $this->seedQuestionSection();
            $this->command->info('Question section seeded successfully.');

            $this->seedQuestionType();
            $this->command->info('Question type seeded successfully.');

            $this->seedQuestion();
            $this->command->info('Question seeded successfully.');

            $this->seedQuestionOption();
            $this->command->info('Question option seeded successfully.');
        }
        else {
            $this->command->info('Question already seeded.');
        }
    }

    private function seedQuestionSection() {

        $data = [
            [
                'id' => '37f79de7-204e-4666-aeed-6432fe04528f',
                'name' => 'Profil Responden',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => '7be24492-6839-4b59-bb00-9adff60c986e',
                'name' => 'Profil Waktu tunggu (bekerja, bukan wirausaha)',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => '51d44ef2-db84-41db-8fa6-57f0d5c92c7b',
                'name' => 'Profil Waktu tunggu (wirausaha)',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        DB::table('question_sections')->insert($data);
    }

    private function seedQuestionType() {

        $data = [
            [
                'id' => '6fa49142-0631-4280-8cea-ea3a35414e44',
                'type' => 'freetext',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'type' => 'option',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        DB::table('question_types')->insert($data);
    }

    private function seedQuestion() {

        $questionWithOption = $this->getQuestionWithOption();
        $questions = array_map(function($val){
            unset($val['options']);
            return $val;
        }, $questionWithOption);

        DB::table('questions')->insert($questions);
    }

    private function seedQuestionOption() {
        $questionWithOption = $this->getQuestionWithOption();
        $options = [];
        foreach ($questionWithOption as $question) {
            foreach ($question['options'] as $option) {
                $option['question_id'] = $question['id'];
                $options[] = $option;
            }
        }

        DB::table('question_options')->insert($options);
    }

    private function getQuestionWithOption() {
        return [
            // Profil responden
            [
                'id' => '1897cfad-9b30-47aa-b7bc-257b262983d2',
                'question' => 'Tahun kelulusan?',
                'question_section_id' => '37f79de7-204e-4666-aeed-6432fe04528f',
                'question_type_id' => '6fa49142-0631-4280-8cea-ea3a35414e44',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => []
            ],
            [
                'id' => 'a34de7b6-f2c6-408c-ac7f-4c6601d0edcf',
                'question' => 'IPK kelulusan?',
                'question_section_id' => '37f79de7-204e-4666-aeed-6432fe04528f',
                'question_type_id' => '6fa49142-0631-4280-8cea-ea3a35414e44',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => []
            ],
            [
                'id' => 'b3ea5c8a-1ddc-43e8-bbb3-83d90498a499',
                'question' => 'Lama studi?',
                'question_section_id' => '37f79de7-204e-4666-aeed-6432fe04528f',
                'question_type_id' => '6fa49142-0631-4280-8cea-ea3a35414e44',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => []
            ],
            [
                'id' => '564cec47-e003-47ff-b010-4b923c42d18f',
                'question' => 'Pekerjaan?',
                'question_section_id' => '37f79de7-204e-4666-aeed-6432fe04528f',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => '0ed9d36f-31af-4e20-a63c-dd3440c60a15',
                        'option' => 'Bekerja',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '4c0e2206-475c-48a2-b6cd-7e64dc78f36f',
                        'option' => 'Tidak bekerja',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '9a54b278-0f43-449f-967f-e21eb63812e0',
                        'option' => 'Melanjutkan studi',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '71ae9822-7c5a-4e21-826b-75a3f73c7023',
                        'option' => 'Wirausaha',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'b73ba59e-42ec-4bc7-80a5-da27c71479e0',
                        'option' => 'Lainnya',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            [
                'id' => 'b6d3916a-4bd3-43c0-8b89-aecd0af3a014',
                'question' => 'Jenis tempat bekerja?',
                'question_section_id' => '37f79de7-204e-4666-aeed-6432fe04528f',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => '75da4f9a-ca98-421a-baf2-ce58cca0aba5',
                        'option' => 'Instansi Pemerintah (termasuk BUMN)',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '541e9553-c17b-4304-b436-bac7e61b9ef9',
                        'option' => 'Lembaga Swadaya Masyarakat',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '3ab46aab-381f-4bfb-974b-f04779a07ff6',
                        'option' => 'Perusahaan Swasta',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'eb925237-05da-481e-a0ab-30cd2ce9c94d',
                        'option' => 'Usaha Sendiri',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            [
                'id' => '8f034dbb-7121-4ce7-a889-a8456b7335aa',
                'question' => 'Level tempat bekerja?',
                'question_section_id' => '37f79de7-204e-4666-aeed-6432fe04528f',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => 'd4220057-6286-419a-b4bb-cf9430e133e9',
                        'option' => 'Lokal',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'b96f2eb6-e31f-4b11-922e-999da4531ff0',
                        'option' => 'Nasional',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'd9b4a9b3-ec25-4e1f-a8b0-dce47aff9ab4',
                        'option' => 'Multinasional/Internasional',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            // waktu tunggu (bekerja)
            [
                'id' => 'f8ca2b1f-2bbd-49b0-abaa-adaffd03635e',
                'question' => 'Kapan mulai mencari pekerjaan?',
                'question_section_id' => '7be24492-6839-4b59-bb00-9adff60c986e',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => '82cca42d-2236-4a6e-9cf7-2c6aee08b8fe',
                        'option' => 'Sebulan Sebelum Lulus',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'b65f4ff6-e616-47ea-8dea-6bf745e4ce79',
                        'option' => 'Sebulan Setelah Lulus',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '0eb16841-9ff7-483b-b2e8-a8959ca2d0b4',
                        'option' => '3 Bulan Setelah Lulus',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'dab7d1e2-8282-4b19-a37a-d388775ffa7e',
                        'option' => '> 3 Bulan Setelah Lulus',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '76c9a7c2-54ae-4679-ae59-0e69a6ec510b',
                        'option' => 'Lainnya',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            [
                'id' => '40be258c-2ac6-4f39-8105-0a45aa999e14',
                'question' => 'Berapa banyak perusahaan/institusi yang sudah dilamar untuk mendapatkan pekerjaan pertama?',
                'question_section_id' => '7be24492-6839-4b59-bb00-9adff60c986e',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => 'bb405ea7-d653-4be3-9684-5d8664118207',
                        'option' => '< 3',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'b4d77689-84ba-41ae-8d25-c8c4960b88a7',
                        'option' => '3 - 5',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'e65d858c-1506-43ff-8786-ecb0c3ed94b7',
                        'option' => '6 - 10',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'b1cd4a72-aba4-4034-b57f-048c841772bc',
                        'option' => '> 10',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            [
                'id' => 'ea0daa51-252e-40a4-9f87-f9aba63dbe66',
                'question' => 'Bagaimana cara mencari pekerjaan tersebut?',
                'question_section_id' => '7be24492-6839-4b59-bb00-9adff60c986e',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => '949f2023-a33e-4e56-b864-cdbf300c2c50',
                        'option' => 'Melalui Iklan',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '8f8eeaf1-a9c8-485d-bb94-b203a876e014',
                        'option' => 'Melalui Relasi',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'a7ccef44-df75-47c2-80c5-e9f8838da926',
                        'option' => 'Pergi ke Bursa Kerja',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'aa13567d-6fcf-4742-b59a-56c1dc3b6eb8',
                        'option' => 'Melalui Informasi Pusat Karir USB',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'fe21884f-be94-46a2-ad2f-276022abb8a8',
                        'option' => 'Lainnya',
                        'can_freetext' => true,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            [
                'id' => '0d03fd59-0b66-4572-8cca-8025deae17d7',
                'question' => 'Berapa banyak yang merespon lamaran?',
                'question_section_id' => '7be24492-6839-4b59-bb00-9adff60c986e',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => '69c262cd-aecb-4e0d-9a38-028dae6b3af6',
                        'option' => '< 3',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '21df6acc-43bc-4ed4-aa9e-260bf442635a',
                        'option' => '3 - 5',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '92be1ef4-0dac-4a96-a135-e00e276c4ff2',
                        'option' => '6 - 10',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '774201af-7b11-4474-b0ac-24ef14fcec1e',
                        'option' => '> 10',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            [
                'id' => '213f20f0-3c86-4e03-85cd-45e324e66e4b',
                'question' => 'Berapa bulan waktu yang dihabiskan (sebelum dan sesudah kelulusan) untuk memeroleh pekerjaan pertama?',
                'question_section_id' => '7be24492-6839-4b59-bb00-9adff60c986e',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => '1f2f902b-5188-4e0f-a664-69e469e0a883',
                        'option' => '1 - 3 Bulan',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '860c622a-d636-4399-9fbd-35c287ac1ee1',
                        'option' => '4 - 6 Bulan',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '7e7d7e87-e94b-404f-b388-c95654b3dbe7',
                        'option' => '7 - 12 Bulan',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '5c252bb0-02c4-4010-8554-f492a2e5d526',
                        'option' => '> 1 tahun',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            [
                'id' => 'c16509bb-1862-42ae-9448-91a8a5bf4aa9',
                'question' => 'Seberapa erat hubungan bidang studi dengan pekerjaan/bidang wirausaha?',
                'question_section_id' => '7be24492-6839-4b59-bb00-9adff60c986e',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => '78d45868-6850-457e-9989-8f9b0fde3494',
                        'option' => 'Sangat Erat',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'f17cb55f-9ed7-412b-b7ac-40cef705df4d',
                        'option' => 'Erat',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '435c2b32-7be6-4bd0-8a94-7e416b787cff',
                        'option' => 'Cukup Erat',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'ffc6dcec-0bb6-4719-814d-53768ce22d53',
                        'option' => 'Kurang Erat',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            [
                'id' => 'c129b105-231a-4e82-afc5-af77a443bb83',
                'question' => 'Apakah bidang pekerjaan/wirausaha sesuai dengan kompetensi akademik?',
                'question_section_id' => '7be24492-6839-4b59-bb00-9adff60c986e',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => '82ca12d8-5e48-4b6a-adae-efbf2d61f17a',
                        'option' => 'Sangat Sesuai',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '6c0f535c-5a17-4cc0-bbd7-fad6926e68f7',
                        'option' => 'Sesuai',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '5f2c6c17-a9bd-452e-86e1-0d6dc3350221',
                        'option' => 'Cukup Sesuai',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '772ca41c-4576-48b4-9ac6-aeaf3811c80f',
                        'option' => 'Kurang Sesuai',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'ea4b0de7-8ec4-4f42-9966-c83cdd3d8c33',
                        'option' => 'Sama Sekali Tidak Sesuai',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            // waktu tunggu (wirausaha)
            [
                'id' => '8c156dc9-348e-41c1-891b-a9d523a22561',
                'question' => 'Sejak kapan memiliki keinginan berwirausaha?',
                'question_section_id' => '51d44ef2-db84-41db-8fa6-57f0d5c92c7b',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => '6ab5125d-1934-4ac7-8acb-149b6c183e22',
                        'option' => 'Sebelum Kuliah',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '5b1ef0c0-5311-40a0-8e28-e69979493a78',
                        'option' => 'Saat Kuliah setelah Mengikuti Pelatihan Kewirausahaan',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'ef8e4543-0262-4c24-b0e8-0d629c4fbbff',
                        'option' => 'Setelah Lulus Kuliah',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '2a3f02ee-4791-4415-954b-058b406a35f0',
                        'option' => 'Lainnya',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
            [
                'id' => '9f5c6968-f17a-4a83-b05c-ca67d1e39a22',
                'question' => 'Apa alasan memutuskan untuk berwirausaha? (boleh lebih dari 1, paling banyak 2)',
                'question_section_id' => '51d44ef2-db84-41db-8fa6-57f0d5c92c7b',
                'question_type_id' => 'cb11c11e-19e8-4754-84f7-b9d660fd4966',
                'created_at' => date('Y-m-d H:i:s'),
                'options' => [
                    [
                        'id' => '59fed330-690d-487b-b8ca-a502f4f14efa',
                        'option' => 'Cita-Cita',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => 'b3da7073-301a-4e68-b66b-d2cc01f5b224',
                        'option' => 'Pertimbangan Waktu Kerja Fleksibel',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '8a2ec212-d853-48fa-ae7e-b91dbb230bb1',
                        'option' => 'Bebas Berkreasi',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '1bf9558a-b940-4418-a6e7-d6c5d8d335b9',
                        'option' => 'Meneruskan Usaha Keluarga',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                    [
                        'id' => '7c0c2589-3937-40e5-a53e-d90cfbdfd767',
                        'option' => 'Lainnya',
                        'can_freetext' => false,
                        'question_id' => '-- inherit --'
                    ],
                ]
            ],
        ];
    }

}
