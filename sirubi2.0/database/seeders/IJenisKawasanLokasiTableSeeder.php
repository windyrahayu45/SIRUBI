<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IJenisKawasanLokasiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_jenis_kawasan_lokasi')->delete();
        
        DB::table('i_jenis_kawasan_lokasi')->insert(array (
            0 => 
            array (
                'id_jenis_kawasan_lokasi' => 1,
                'jenis_kawasan_lokasi' => 'Dataran Banjir',
            ),
            1 => 
            array (
                'id_jenis_kawasan_lokasi' => 2,
                'jenis_kawasan_lokasi' => 'KEK',
            ),
            2 => 
            array (
                'id_jenis_kawasan_lokasi' => 3,
                'jenis_kawasan_lokasi' => 'Perbatasan',
            ),
            3 => 
            array (
                'id_jenis_kawasan_lokasi' => 4,
                'jenis_kawasan_lokasi' => 'Kumuh',
            ),
            4 => 
            array (
                'id_jenis_kawasan_lokasi' => 5,
                'jenis_kawasan_lokasi' => 'Transmigrasi',
            ),
            5 => 
            array (
                'id_jenis_kawasan_lokasi' => 6,
                'jenis_kawasan_lokasi' => 'Rawan Bencana',
            ),
            6 => 
            array (
                'id_jenis_kawasan_lokasi' => 7,
                'jenis_kawasan_lokasi' => 'Diperuntukan Untuk Permukiman',
            ),
            7 => 
            array (
                'id_jenis_kawasan_lokasi' => 8,
                'jenis_kawasan_lokasi' => 'KSPN',
            ),
            8 => 
            array (
                'id_jenis_kawasan_lokasi' => 9,
                'jenis_kawasan_lokasi' => 'Daerah Tertnggal dan Terpencil',
            ),
            9 => 
            array (
                'id_jenis_kawasan_lokasi' => 10,
                'jenis_kawasan_lokasi' => 'Dekat Jalur Berbahaya (Jalur Kereta, Lereng, SUTET',
                ),
            ));
        
        
    }
}