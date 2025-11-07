<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BKondisiVentilasiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_kondisi_ventilasi')->delete();
        
        DB::table('b_kondisi_ventilasi')->insert(array (
            0 => 
            array (
                'id_kondisi_ventilasi' => 1,
                'kondisi_ventilasi' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_ventilasi' => 2,
                'kondisi_ventilasi' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_ventilasi' => 3,
                'kondisi_ventilasi' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_ventilasi' => 4,
                'kondisi_ventilasi' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_ventilasi' => 5,
                'kondisi_ventilasi' => 'Tidak Ada',
            ),
        ));
        
        
    }
}