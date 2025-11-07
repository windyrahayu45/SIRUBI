<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IJenisKelaminTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_jenis_kelamin')->delete();
        
        DB::table('i_jenis_kelamin')->insert(array (
            0 => 
            array (
                'id_jenis_kelamin' => 1,
                'jenis_kelamin' => 'Laki-laki',
            ),
            1 => 
            array (
                'id_jenis_kelamin' => 2,
                'jenis_kelamin' => 'Perempuan',
            ),
        ));
        
        
    }
}