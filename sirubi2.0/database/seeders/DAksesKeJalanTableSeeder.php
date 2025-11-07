<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DAksesKeJalanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_akses_ke_jalan')->delete();
        
        DB::table('d_akses_ke_jalan')->insert(array (
            0 => 
            array (
                'id_akses_ke_jalan' => 1,
                'akses_ke_jalan' => 'Iya',
            ),
            1 => 
            array (
                'id_akses_ke_jalan' => 2,
                'akses_ke_jalan' => 'Tidak',
            ),
        ));
        
        
    }
}