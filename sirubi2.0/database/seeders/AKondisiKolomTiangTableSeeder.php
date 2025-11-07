<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AKondisiKolomTiangTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('a_kondisi_kolom_tiang')->delete();
        
        DB::table('a_kondisi_kolom_tiang')->insert(array (
            0 => 
            array (
                'id_kondisi_kolom_tiang' => 1,
                'kondisi_kolom_tiang' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_kolom_tiang' => 2,
                'kondisi_kolom_tiang' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_kolom_tiang' => 3,
                'kondisi_kolom_tiang' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_kolom_tiang' => 4,
                'kondisi_kolom_tiang' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_kolom_tiang' => 5,
                'kondisi_kolom_tiang' => 'Tidak Ada',
            ),
        ));
        
        
    }
}