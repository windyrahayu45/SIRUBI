<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DBangunanBeradaLimbahTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_bangunan_berada_limbah')->delete();
        
        DB::table('d_bangunan_berada_limbah')->insert(array (
            0 => 
            array (
                'id_bangunan_berada_limbah' => 1,
                'bangunan_berada_limbah' => 'Iya',
            ),
            1 => 
            array (
                'id_bangunan_berada_limbah' => 2,
                'bangunan_berada_limbah' => 'Tidak',
            ),
        ));
        
        
    }
}