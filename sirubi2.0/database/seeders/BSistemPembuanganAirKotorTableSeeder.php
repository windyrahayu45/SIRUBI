<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BSistemPembuanganAirKotorTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_sistem_pembuangan_air_kotor')->delete();
        
        DB::table('b_sistem_pembuangan_air_kotor')->insert(array (
            0 => 
            array (
                'id_sistem_pembuangan_air_kotor' => 1,
                'sistem_pembuangan_air_kotor' => 'Ada, Septic Tank / IPAL',
            ),
            1 => 
            array (
                'id_sistem_pembuangan_air_kotor' => 2,
                'sistem_pembuangan_air_kotor' => 'Ada, Saluran Kota',
            ),
            2 => 
            array (
                'id_sistem_pembuangan_air_kotor' => 3,
                'sistem_pembuangan_air_kotor' => 'Ada, Lingk',
            ),
            3 => 
            array (
                'id_sistem_pembuangan_air_kotor' => 4,
                'sistem_pembuangan_air_kotor' => 'Tidak Ada',
            ),
        ));
        
        
    }
}