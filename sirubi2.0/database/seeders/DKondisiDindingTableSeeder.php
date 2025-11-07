<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DKondisiDindingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_kondisi_dinding')->delete();
        
        DB::table('d_kondisi_dinding')->insert(array (
            0 => 
            array (
                'id_kondisi_dinding' => 1,
                'kondisi_dinding' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_dinding' => 2,
                'kondisi_dinding' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_dinding' => 3,
                'kondisi_dinding' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_dinding' => 4,
                'kondisi_dinding' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_dinding' => 5,
                'kondisi_dinding' => 'Tidak Ada',
            ),
        ));
        
        
    }
}