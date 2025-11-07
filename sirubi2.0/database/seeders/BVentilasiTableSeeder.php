<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BVentilasiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_ventilasi')->delete();
        
        DB::table('b_ventilasi')->insert(array (
            0 => 
            array (
                'id_ventilasi' => 1,
                'ventilasi' => 'Layak',
            ),
            1 => 
            array (
                'id_ventilasi' => 2,
                'ventilasi' => 'Tidak Layak',
            ),
            2 => 
            array (
                'id_ventilasi' => 3,
                'ventilasi' => 'Tidak Ada',
            ),
        ));
        
        
    }
}