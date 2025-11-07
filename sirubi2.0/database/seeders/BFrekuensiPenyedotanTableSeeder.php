<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BFrekuensiPenyedotanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_frekuensi_penyedotan')->delete();
        
        DB::table('b_frekuensi_penyedotan')->insert(array (
            0 => 
            array (
                'id_frekuensi_penyedotan' => 1,
                'frekuensi_penyedotan' => '6 Kali atau lebih',
            ),
            1 => 
            array (
                'id_frekuensi_penyedotan' => 2,
                'frekuensi_penyedotan' => 'Kurang Dari 6 Kali',
            ),
            2 => 
            array (
                'id_frekuensi_penyedotan' => 3,
                'frekuensi_penyedotan' => 'Tidak Pernah',
            ),
        ));
        
        
    }
}