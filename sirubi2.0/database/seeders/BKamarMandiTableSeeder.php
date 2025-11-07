<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BKamarMandiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_kamar_mandi')->delete();
        
        DB::table('b_kamar_mandi')->insert(array (
            0 => 
            array (
                'id_kamar_mandi' => 1,
                'kamar_mandi' => 'Sendiri',
            ),
            1 => 
            array (
                'id_kamar_mandi' => 2,
                'kamar_mandi' => 'Bersama/MKC Komunal',
            ),
            2 => 
            array (
                'id_kamar_mandi' => 3,
                'kamar_mandi' => 'Tidak Ada',
            ),
        ));
        
        
    }
}