<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BKondisiJendelaLubangCahayaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_kondisi_jendela_lubang_cahaya')->delete();
        
        DB::table('b_kondisi_jendela_lubang_cahaya')->insert(array (
            0 => 
            array (
                'id_kondisi_jendela_lubang_cahaya' => 1,
                'kondisi_jendela_lubang_cahaya' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_jendela_lubang_cahaya' => 2,
                'kondisi_jendela_lubang_cahaya' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_jendela_lubang_cahaya' => 3,
                'kondisi_jendela_lubang_cahaya' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_jendela_lubang_cahaya' => 4,
                'kondisi_jendela_lubang_cahaya' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_jendela_lubang_cahaya' => 5,
                'kondisi_jendela_lubang_cahaya' => 'Tidak Ada',
            ),
        ));
        
        
    }
}