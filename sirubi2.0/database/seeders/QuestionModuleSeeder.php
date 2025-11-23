<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionModuleSeeder extends Seeder
{
    public function run()
    {
       DB::table('survey_question_modules')->insert([
    [
        'module' => 'lokasi',
        'label'  => 'Lokasi',
    ],
    [
        'module' => 'penghuni_rumah',
        'label'  => 'Penghuni Rumah',
    ],
    [
        'module' => 'identitas_rumah',
        'label'  => 'Identitas Rumah',
    ],
    [
        'module' => 'aspek_keselamatan',
        'label'  => 'Aspek Keselamatan',
    ],
    [
        'module' => 'aspek_kesehatan',
        'label'  => 'Aspek Kesehatan',
    ],
    [
        'module' => 'aspek_luas_kebutuhan',
        'label'  => 'Aspek Persyaratan Luas Dan Kebutuhan Ruang',
    ],
    [
        'module' => 'aspek_bahan_bangunan',
        'label'  => 'Aspek Komponen Bahan Bangunan',
    ],
    [
        'module' => 'foto_dokumentasi',
        'label'  => 'Foto/Dokumentasi',
    ],
]);

    }
}
