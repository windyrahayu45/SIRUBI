<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TblJenisPondasiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('tbl_jenis_pondasi')->delete();
        
        DB::table('tbl_jenis_pondasi')->insert(array (
            0 => 
            array (
                'id_jenis_pondasi' => 1,
                'nama_jenis_pondasi' => 'Pondasi Bata',
            ),
            1 => 
            array (
                'id_jenis_pondasi' => 2,
                'nama_jenis_pondasi' => 'Pondasi Batu Kali',
            ),
            2 => 
            array (
                'id_jenis_pondasi' => 3,
                'nama_jenis_pondasi' => 'Pondasi Tapak Gajah',
            ),
            3 => 
            array (
                'id_jenis_pondasi' => 4,
                'nama_jenis_pondasi' => 'Pondasi Sumuran',
            ),
            4 => 
            array (
                'id_jenis_pondasi' => 5,
                'nama_jenis_pondasi' => 'Pondasi Tiang Pancang',
            ),
            5 => 
            array (
                'id_jenis_pondasi' => 6,
                'nama_jenis_pondasi' => 'Lainnya',
            ),
            6 => 
            array (
                'id_jenis_pondasi' => 7,
                'nama_jenis_pondasi' => 'Tidak Ada',
            ),
        ));
        
        
    }
}