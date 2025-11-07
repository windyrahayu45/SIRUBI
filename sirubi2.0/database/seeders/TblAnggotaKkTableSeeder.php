<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TblAnggotaKkTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('tbl_anggota_kk')->delete();
        
        DB::table('tbl_anggota_kk')->insert(array (
            0 => 
            array (
                'id_anggota_kk' => 1,
                'anggota_kk' => '1 Anggota',
            ),
            1 => 
            array (
                'id_anggota_kk' => 2,
                'anggota_kk' => '2 Anggota',
            ),
            2 => 
            array (
                'id_anggota_kk' => 3,
                'anggota_kk' => '3 Anggota',
            ),
            3 => 
            array (
                'id_anggota_kk' => 4,
                'anggota_kk' => '4 Anggota',
            ),
            4 => 
            array (
                'id_anggota_kk' => 5,
                'anggota_kk' => '5 Anggota',
            ),
            5 => 
            array (
                'id_anggota_kk' => 6,
                'anggota_kk' => '6 Anggota',
            ),
            6 => 
            array (
                'id_anggota_kk' => 7,
                'anggota_kk' => '7 Anggota',
            ),
            7 => 
            array (
                'id_anggota_kk' => 8,
                'anggota_kk' => '8 Anggota',
            ),
            8 => 
            array (
                'id_anggota_kk' => 9,
                'anggota_kk' => '9 Anggota',
            ),
            9 => 
            array (
                'id_anggota_kk' => 10,
                'anggota_kk' => '10 Anggota',
            ),
        ));
        
        
    }
}