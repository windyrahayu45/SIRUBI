<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DKondisiPenutupAtapTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_kondisi_penutup_atap')->delete();
        
        DB::table('d_kondisi_penutup_atap')->insert(array (
            0 => 
            array (
                'id_kondisi_penutup_atap' => 1,
                'kondisi_penutup_atap' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_penutup_atap' => 2,
                'kondisi_penutup_atap' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_penutup_atap' => 3,
                'kondisi_penutup_atap' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_penutup_atap' => 4,
                'kondisi_penutup_atap' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_penutup_atap' => 5,
                'kondisi_penutup_atap' => 'Tidak Ada',
            ),
        ));
        
        
    }
}