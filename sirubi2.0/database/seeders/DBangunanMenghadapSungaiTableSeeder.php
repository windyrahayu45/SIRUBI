<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DBangunanMenghadapSungaiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_bangunan_menghadap_sungai')->delete();
        
        DB::table('d_bangunan_menghadap_sungai')->insert(array (
            0 => 
            array (
                'id_bangunan_menghadap_sungai' => 1,
                'bangunan_menghadap_sungai' => 'Iya',
            ),
            1 => 
            array (
                'id_bangunan_menghadap_sungai' => 2,
                'bangunan_menghadap_sungai' => 'Tidak',
            ),
        ));
        
        
    }
}