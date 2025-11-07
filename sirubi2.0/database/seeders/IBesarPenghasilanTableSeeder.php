<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IBesarPenghasilanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_besar_penghasilan')->delete();
        
        DB::table('i_besar_penghasilan')->insert(array (
            0 => 
            array (
                'id_besar_penghasilan' => 1,
                'besar_penghasilan' => '< 1,2 Juta',
            ),
            1 => 
            array (
                'id_besar_penghasilan' => 2,
                'besar_penghasilan' => '1,3 - 1,8 Juta',
            ),
            2 => 
            array (
                'id_besar_penghasilan' => 3,
                'besar_penghasilan' => '1,9 - 2,1 Juta',
            ),
            3 => 
            array (
                'id_besar_penghasilan' => 4,
                'besar_penghasilan' => '2,2 - 2,6 Juta',
            ),
            4 => 
            array (
                'id_besar_penghasilan' => 5,
                'besar_penghasilan' => '2,7 - 3,1 Juta',
            ),
            5 => 
            array (
                'id_besar_penghasilan' => 6,
                'besar_penghasilan' => '3,2 - 3,6 Juta',
            ),
            6 => 
            array (
                'id_besar_penghasilan' => 7,
                'besar_penghasilan' => '3,7 - 4,2 Juta',
            ),
            7 => 
            array (
                'id_besar_penghasilan' => 8,
                'besar_penghasilan' => '> 4,2 Juta',
            ),
        ));
        
        
    }
}