<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AKondisiSloofTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('a_kondisi_sloof')->delete();
        
        DB::table('a_kondisi_sloof')->insert(array (
            0 => 
            array (
                'id_kondisi_sloof' => 1,
                'kondisi_sloof' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_sloof' => 2,
                'kondisi_sloof' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_sloof' => 3,
                'kondisi_sloof' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_sloof' => 4,
                'kondisi_sloof' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_sloof' => 5,
                'kondisi_sloof' => 'Tidak Ada',
            ),
        ));
        
        
    }
}