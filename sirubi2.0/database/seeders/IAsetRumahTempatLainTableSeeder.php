<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IAsetRumahTempatLainTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_aset_rumah_tempat_lain')->delete();
        
        DB::table('i_aset_rumah_tempat_lain')->insert(array (
            0 => 
            array (
                'id_aset_rumah_tempat_lain' => 1,
                'aset_rumah_tempat_lain' => 'Ada, Rumah',
            ),
            1 => 
            array (
                'id_aset_rumah_tempat_lain' => 2,
                'aset_rumah_tempat_lain' => 'Ada, Ruko',
            ),
            2 => 
            array (
                'id_aset_rumah_tempat_lain' => 3,
                'aset_rumah_tempat_lain' => 'Ada, Warung',
            ),
            3 => 
            array (
                'id_aset_rumah_tempat_lain' => 4,
                'aset_rumah_tempat_lain' => 'Ada, Kos-kosan',
            ),
            4 => 
            array (
                'id_aset_rumah_tempat_lain' => 5,
                'aset_rumah_tempat_lain' => 'Tidak Ada',
            ),
        ));
        
        
    }
}