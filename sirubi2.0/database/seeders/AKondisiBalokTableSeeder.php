<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AKondisiBalokTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('a_kondisi_balok')->delete();
        
        \DB::table('a_kondisi_balok')->insert(array (
            0 => 
            array (
                'id_kondisi_balok' => 1,
                'kondisi_balok' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_balok' => 2,
                'kondisi_balok' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_balok' => 3,
                'kondisi_balok' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_balok' => 4,
                'kondisi_balok' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_balok' => 5,
                'kondisi_balok' => 'Tidak Ada',
            ),
        ));
        
        
    }
}