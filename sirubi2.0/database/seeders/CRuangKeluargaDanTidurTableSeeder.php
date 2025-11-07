<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CRuangKeluargaDanTidurTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('c_ruang_keluarga_dan_tidur')->delete();
        
        DB::table('c_ruang_keluarga_dan_tidur')->insert(array (
            0 => 
            array (
                'id_ruang_keluarga_dan_tidur' => 1,
                'ruang_keluarga_dan_tidur' => 'Ada',
            ),
            1 => 
            array (
                'id_ruang_keluarga_dan_tidur' => 2,
                'ruang_keluarga_dan_tidur' => 'Tidak Ada',
            ),
        ));
        
        
    }
}