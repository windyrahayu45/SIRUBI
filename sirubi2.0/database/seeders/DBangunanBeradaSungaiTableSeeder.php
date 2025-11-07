<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DBangunanBeradaSungaiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_bangunan_berada_sungai')->delete();
        
        DB::table('d_bangunan_berada_sungai')->insert(array (
            0 => 
            array (
                'id_bangunan_berada_sungai' => 1,
                'bangunan_berada_sungai' => 'Iya',
            ),
            1 => 
            array (
                'id_bangunan_berada_sungai' => 2,
                'bangunan_berada_sungai' => 'Tidak',
            ),
        ));
        
        
    }
}