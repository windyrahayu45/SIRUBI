<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BKondisiKamarMandiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_kondisi_kamar_mandi')->delete();
        
        DB::table('b_kondisi_kamar_mandi')->insert(array (
            0 => 
            array (
                'id_kondisi_kamar_mandi' => 1,
                'kondisi_kamar_mandi' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_kamar_mandi' => 2,
                'kondisi_kamar_mandi' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_kamar_mandi' => 3,
                'kondisi_kamar_mandi' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_kamar_mandi' => 4,
                'kondisi_kamar_mandi' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_kamar_mandi' => 5,
                'kondisi_kamar_mandi' => 'Tidak Ada',
            ),
        ));
        
        
    }
}