<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IPekerjaanUtamaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_pekerjaan_utama')->delete();
        
        DB::table('i_pekerjaan_utama')->insert(array (
            0 => 
            array (
                'id_pekerjaan_utama' => 1,
                'pekerjaan_utama' => 'PNS',
            ),
            1 => 
            array (
                'id_pekerjaan_utama' => 2,
                'pekerjaan_utama' => 'TNI/POLRI',
            ),
            2 => 
            array (
                'id_pekerjaan_utama' => 3,
                'pekerjaan_utama' => 'BUMN/D',
            ),
            3 => 
            array (
                'id_pekerjaan_utama' => 4,
                'pekerjaan_utama' => 'Pensiunan',
            ),
            4 => 
            array (
                'id_pekerjaan_utama' => 5,
                'pekerjaan_utama' => 'Pramuwisata',
            ),
            5 => 
            array (
                'id_pekerjaan_utama' => 6,
                'pekerjaan_utama' => 'Ojek/Supir',
            ),
            6 => 
            array (
                'id_pekerjaan_utama' => 7,
                'pekerjaan_utama' => 'Honorer',
            ),
            7 => 
            array (
                'id_pekerjaan_utama' => 8,
                'pekerjaan_utama' => 'Karyawan',
            ),
            8 => 
            array (
                'id_pekerjaan_utama' => 9,
                'pekerjaan_utama' => 'Tukang/Montir',
            ),
            9 => 
            array (
                'id_pekerjaan_utama' => 10,
                'pekerjaan_utama' => 'Petani',
            ),
            10 => 
            array (
                'id_pekerjaan_utama' => 11,
                'pekerjaan_utama' => 'Wirausaha',
            ),
            11 => 
            array (
                'id_pekerjaan_utama' => 12,
                'pekerjaan_utama' => 'Lansia/RT',
            ),
            12 => 
            array (
                'id_pekerjaan_utama' => 13,
                'pekerjaan_utama' => 'Nelayan',
            ),
            13 => 
            array (
                'id_pekerjaan_utama' => 14,
                'pekerjaan_utama' => 'Buruh Harian',
            ),
            14 => 
            array (
                'id_pekerjaan_utama' => 15,
                'pekerjaan_utama' => 'Lainnya',
            ),
            15 => 
            array (
                'id_pekerjaan_utama' => 16,
                'pekerjaan_utama' => 'Tidak Bekerja',
            ),
        ));
        
        
    }
}