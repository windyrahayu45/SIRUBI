<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AKondisiPondasiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('a_kondisi_pondasi')->delete();
        
        DB::table('a_kondisi_pondasi')->insert(array (
            0 => 
            array (
                'id_kondisi_pondasi' => 1,
                'kondisi_pondasi' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_pondasi' => 2,
                'kondisi_pondasi' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_pondasi' => 3,
                'kondisi_pondasi' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_pondasi' => 4,
                'kondisi_pondasi' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_pondasi' => 5,
                'kondisi_pondasi' => 'Tidak Ada',
            ),
        ));
        
        
    }
}