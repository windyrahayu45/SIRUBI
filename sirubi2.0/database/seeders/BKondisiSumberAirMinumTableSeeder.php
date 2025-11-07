<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BKondisiSumberAirMinumTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_kondisi_sumber_air_minum')->delete();
        
        DB::table('b_kondisi_sumber_air_minum')->insert(array (
            0 => 
            array (
                'id_kondisi_sumber_air_minum' => 1,
                'kondisi_sumber_air_minum' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_sumber_air_minum' => 2,
                'kondisi_sumber_air_minum' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_sumber_air_minum' => 3,
                'kondisi_sumber_air_minum' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_sumber_air_minum' => 4,
                'kondisi_sumber_air_minum' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_sumber_air_minum' => 5,
                'kondisi_sumber_air_minum' => 'Tidak Ada',
            ),
        ));
        
        
    }
}