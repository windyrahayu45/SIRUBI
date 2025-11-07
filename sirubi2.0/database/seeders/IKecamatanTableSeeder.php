<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IKecamatanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_kecamatan')->delete();
        
        DB::table('i_kecamatan')->insert(array (
            0 => 
            array (
                'id_kecamatan' => 1,
                'nama_kecamatan' => 'Aur Birugo Tigo Baleh',
            ),
            1 => 
            array (
                'id_kecamatan' => 2,
                'nama_kecamatan' => 'Guguk Panjang',
            ),
            2 => 
            array (
                'id_kecamatan' => 3,
                'nama_kecamatan' => 'Mandiangin Koto Selayan',
            ),
        ));
        
        
    }
}