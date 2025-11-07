<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IJumlahKkTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_jumlah_kk')->delete();
        
        DB::table('i_jumlah_kk')->insert(array (
            0 => 
            array (
                'id_jumlah_kk' => 1,
                'jumlah_kk' => '1 Kartu Keluarga',
            ),
            1 => 
            array (
                'id_jumlah_kk' => 2,
                'jumlah_kk' => '2 Kartu Keluarga',
            ),
            2 => 
            array (
                'id_jumlah_kk' => 3,
                'jumlah_kk' => '3 Kartu Keluarga',
            ),
            3 => 
            array (
                'id_jumlah_kk' => 4,
                'jumlah_kk' => '4 Kartu Keluarga',
            ),
            4 => 
            array (
                'id_jumlah_kk' => 5,
                'jumlah_kk' => '5 Kartu Keluarga',
            ),
            5 => 
            array (
                'id_jumlah_kk' => 6,
                'jumlah_kk' => '6 Kartu Keluarga',
            ),
        ));
        
        
    }
}