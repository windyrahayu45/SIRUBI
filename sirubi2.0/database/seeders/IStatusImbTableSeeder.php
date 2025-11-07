<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IStatusImbTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_status_imb')->delete();
        
        DB::table('i_status_imb')->insert(array (
            0 => 
            array (
                'id_status_imb' => 1,
                'status_imb' => 'Ada',
            ),
            1 => 
            array (
                'id_status_imb' => 2,
                'status_imb' => 'Tidak Ada',
            ),
        ));
        
        
    }
}