<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class APondasiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('a_pondasi')->delete();
        
        DB::table('a_pondasi')->insert(array (
            0 => 
            array (
                'id_pondasi' => 1,
                'pondasi' => 'Ada',
            ),
            1 => 
            array (
                'id_pondasi' => 2,
                'pondasi' => 'Tidak Ada',
            ),
        ));
        
        
    }
}