<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BJendelaLubangCahayaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_jendela_lubang_cahaya')->delete();
        
        DB::table('b_jendela_lubang_cahaya')->insert(array (
            0 => 
            array (
                'id_jendela_lubang_cahaya' => 1,
                'jendela_lubang_cahaya' => 'Layak',
            ),
            1 => 
            array (
                'id_jendela_lubang_cahaya' => 2,
                'jendela_lubang_cahaya' => 'Tidak Layak',
            ),
            2 => 
            array (
                'id_jendela_lubang_cahaya' => 3,
                'jendela_lubang_cahaya' => 'Tidak Ada',
            ),
        ));
        
        
    }
}