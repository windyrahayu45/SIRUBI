<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AKondisiStrukturAtapTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('a_kondisi_struktur_atap')->delete();
        
        DB::table('a_kondisi_struktur_atap')->insert(array (
            0 => 
            array (
                'id_kondisi_struktur_atap' => 1,
                'kondisi_struktur_atap' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_struktur_atap' => 2,
                'kondisi_struktur_atap' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_struktur_atap' => 3,
                'kondisi_struktur_atap' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_struktur_atap' => 4,
                'kondisi_struktur_atap' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_struktur_atap' => 5,
                'kondisi_struktur_atap' => 'Tidak Ada',
            ),
        ));
        
        
    }
}