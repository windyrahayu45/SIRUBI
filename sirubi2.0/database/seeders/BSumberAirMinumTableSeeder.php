<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BSumberAirMinumTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_sumber_air_minum')->delete();
        
        DB::table('b_sumber_air_minum')->insert(array (
            0 => 
            array (
                'id_sumber_air_minum' => 1,
                'sumber_air_minum' => 'PDAM',
            ),
            1 => 
            array (
                'id_sumber_air_minum' => 2,
                'sumber_air_minum' => 'Air Kemasan/Isi Ulang',
            ),
            2 => 
            array (
                'id_sumber_air_minum' => 3,
                'sumber_air_minum' => 'Sumur',
            ),
            3 => 
            array (
                'id_sumber_air_minum' => 4,
                'sumber_air_minum' => 'Mata Air',
            ),
            4 => 
            array (
                'id_sumber_air_minum' => 5,
                'sumber_air_minum' => 'Air Hujan',
            ),
            5 => 
            array (
                'id_sumber_air_minum' => 6,
                'sumber_air_minum' => 'Lainnya',
            ),
        ));
        
        
    }
}