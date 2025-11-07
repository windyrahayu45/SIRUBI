<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BKondisiSistemPembuanganAirKotorTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_kondisi_sistem_pembuangan_air_kotor')->delete();
        
        DB::table('b_kondisi_sistem_pembuangan_air_kotor')->insert(array (
            0 => 
            array (
                'id_kondisi_sistem_pembuangan_air_kotor' => 1,
                'kondisi_sistem_pembuangan_air_kotor' => 'Baik',
            ),
            1 => 
            array (
                'id_kondisi_sistem_pembuangan_air_kotor' => 2,
                'kondisi_sistem_pembuangan_air_kotor' => 'Rusak Ringan',
            ),
            2 => 
            array (
                'id_kondisi_sistem_pembuangan_air_kotor' => 3,
                'kondisi_sistem_pembuangan_air_kotor' => 'Rusak Sedang/Sebagian',
            ),
            3 => 
            array (
                'id_kondisi_sistem_pembuangan_air_kotor' => 4,
                'kondisi_sistem_pembuangan_air_kotor' => 'Rusak Berat/Seluruhnya',
            ),
            4 => 
            array (
                'id_kondisi_sistem_pembuangan_air_kotor' => 5,
                'kondisi_sistem_pembuangan_air_kotor' => 'Tidak Ada',
            ),
        ));
        
        
    }
}