<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IBesarPengeluaranTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_besar_pengeluaran')->delete();
        
        DB::table('i_besar_pengeluaran')->insert(array (
            0 => 
            array (
                'id_besar_pengeluaran' => 1,
                'besar_pengeluaran' => '< 1,2 Juta',
            ),
            1 => 
            array (
                'id_besar_pengeluaran' => 3,
                'besar_pengeluaran' => '1,9 - 2,1 Juta',
            ),
            2 => 
            array (
                'id_besar_pengeluaran' => 4,
                'besar_pengeluaran' => '2,2 - 2,6 Juta',
            ),
            3 => 
            array (
                'id_besar_pengeluaran' => 5,
                'besar_pengeluaran' => '2,7 - 3,1 Juta',
            ),
            4 => 
            array (
                'id_besar_pengeluaran' => 6,
                'besar_pengeluaran' => '3,2 - 3,6 Juta',
            ),
            5 => 
            array (
                'id_besar_pengeluaran' => 7,
                'besar_pengeluaran' => '3,7 - 4,2 Juta',
            ),
            6 => 
            array (
                'id_besar_pengeluaran' => 8,
                'besar_pengeluaran' => '> 4,2 Juta',
            ),
        ));
        
        
    }
}