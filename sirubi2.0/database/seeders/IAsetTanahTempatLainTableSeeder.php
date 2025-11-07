<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IAsetTanahTempatLainTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_aset_tanah_tempat_lain')->delete();
        
        DB::table('i_aset_tanah_tempat_lain')->insert(array (
            0 => 
            array (
                'id_aset_tanah_tempat_lain' => 1,
                'aset_tanah_tempat_lain' => 'Ada, Sawah',
            ),
            1 => 
            array (
                'id_aset_tanah_tempat_lain' => 2,
                'aset_tanah_tempat_lain' => 'Ada, Kebun/Ladang',
            ),
            2 => 
            array (
                'id_aset_tanah_tempat_lain' => 3,
                'aset_tanah_tempat_lain' => 'Tidak Ada',
            ),
        ));
        
        
    }
}