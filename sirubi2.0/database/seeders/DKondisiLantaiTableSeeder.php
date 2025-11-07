<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DKondisiLantaiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_kondisi_lantai')->delete();
        
        DB::table('d_kondisi_lantai')->insert(array (
            0 => 
            array (
                'id_kondisi_lantai' => 1,
                'kondisi_lantai' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_lantai' => 2,
                'kondisi_lantai' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_lantai' => 3,
                'kondisi_lantai' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_lantai' => 4,
                'kondisi_lantai' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_lantai' => 5,
                'kondisi_lantai' => 'Tidak Ada',
            ),
        ));
        
        
    }
}