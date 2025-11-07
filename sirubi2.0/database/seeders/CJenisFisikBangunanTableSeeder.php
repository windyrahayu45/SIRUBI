<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CJenisFisikBangunanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('c_jenis_fisik_bangunan')->delete();
        
        DB::table('c_jenis_fisik_bangunan')->insert(array (
            0 => 
            array (
                'id_jenis_fisik_bangunan' => 1,
                'jenis_fisik_bangunan' => 'Rumah Bersusun/Deret',
            ),
            1 => 
            array (
                'id_jenis_fisik_bangunan' => 2,
                'jenis_fisik_bangunan' => 'Rumah Tunggal',
            ),
        ));
        
        
    }
}