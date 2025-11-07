<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IPernahMendapatkanBantuanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_pernah_mendapatkan_bantuan')->delete();
        
        DB::table('i_pernah_mendapatkan_bantuan')->insert(array (
            0 => 
            array (
                'id_pernah_mendapatkan_bantuan' => 1,
                'pernah_mendapatkan_bantuan' => 'Pernah',
            ),
            1 => 
            array (
                'id_pernah_mendapatkan_bantuan' => 2,
                'pernah_mendapatkan_bantuan' => 'Tidak Pernah',
            ),
        ));
        
        
    }
}