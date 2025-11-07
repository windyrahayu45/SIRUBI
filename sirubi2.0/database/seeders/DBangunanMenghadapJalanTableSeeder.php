<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DBangunanMenghadapJalanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_bangunan_menghadap_jalan')->delete();
        
        DB::table('d_bangunan_menghadap_jalan')->insert(array (
            0 => 
            array (
                'id_bangunan_menghadap_jalan' => 1,
                'bangunan_menghadap_jalan' => 'Iya',
            ),
            1 => 
            array (
                'id_bangunan_menghadap_jalan' => 2,
                'bangunan_menghadap_jalan' => 'Tidak',
            ),
        ));
        
        
    }
}