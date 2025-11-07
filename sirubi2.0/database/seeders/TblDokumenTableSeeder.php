<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TblDokumenTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('tbl_dokumen')->delete();
        
        DB::table('tbl_dokumen')->insert(array (
            0 => 
            array (
                'id_dokumen' => 10,
            'nama_dokumen' => 'Format Update Status DTKS (Data Terpadu Kesejahteraan Sosial)',
                'source' => '1591697643152.xlsx',
                'date_upload' => '2020-06-09',
            ),
            1 => 
            array (
                'id_dokumen' => 11,
                'nama_dokumen' => 'Format Update Data Bantuan',
                'source' => '1591697674269.xlsx',
                'date_upload' => '2020-06-09',
            ),
            2 => 
            array (
                'id_dokumen' => 12,
                'nama_dokumen' => 'Aplikasi SIRUBI ver 1.0',
                'source' => 'SIRUBI-ver1.0.apk',
                'date_upload' => '2020-06-09',
            ),
        ));
        
        
    }
}