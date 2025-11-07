<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BKondisiJambanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_kondisi_jamban')->delete();
        
        DB::table('b_kondisi_jamban')->insert(array (
            0 => 
            array (
                'id_kondisi_jamban' => 1,
                'kondisi_jamban' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_jamban' => 2,
                'kondisi_jamban' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_jamban' => 3,
                'kondisi_jamban' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_jamban' => 4,
                'kondisi_jamban' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_jamban' => 5,
                'kondisi_jamban' => 'Tidak Ada',
            ),
        ));
        
        
    }
}