<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BJambanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_jamban')->delete();
        
        DB::table('b_jamban')->insert(array (
            0 => 
            array (
                'id_jamban' => 1,
                'jamban' => 'Leher Angsa',
            ),
            1 => 
            array (
                'id_jamban' => 2,
                'jamban' => 'Plengsengan dengan tutup',
            ),
            2 => 
            array (
                'id_jamban' => 3,
                'jamban' => 'Plengsengan tanpa tutup',
            ),
            3 => 
            array (
                'id_jamban' => 4,
                'jamban' => 'Cemplung/cubluk',
            ),
            4 => 
            array (
                'id_jamban' => 5,
                'jamban' => 'Tidak ada',
            ),
        ));
        
        
    }
}