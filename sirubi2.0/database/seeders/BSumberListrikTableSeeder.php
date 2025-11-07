<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BSumberListrikTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('b_sumber_listrik')->delete();
        
        DB::table('b_sumber_listrik')->insert(array (
            0 => 
            array (
                'id_sumber_listrik' => 1,
                'sumber_listrik' => 'PLN Dengan Meteran, Daya 450 VA',
            ),
            1 => 
            array (
                'id_sumber_listrik' => 2,
                'sumber_listrik' => 'PLN Dengan Meteran, Daya 900 VA',
            ),
            2 => 
            array (
                'id_sumber_listrik' => 3,
                'sumber_listrik' => 'PLN Dengan Meteran, Daya 1300 VA',
            ),
            3 => 
            array (
                'id_sumber_listrik' => 4,
                'sumber_listrik' => 'PLN Dengan Meteran, Daya 2200 VA',
            ),
            4 => 
            array (
                'id_sumber_listrik' => 5,
                'sumber_listrik' => 'PLN Dengan Meteran, Daya 3500 VA',
            ),
            5 => 
            array (
                'id_sumber_listrik' => 6,
                'sumber_listrik' => 'PLN Dengan Meteran, Daya 4400 VA',
            ),
            6 => 
            array (
                'id_sumber_listrik' => 7,
                'sumber_listrik' => 'PLN Tanpa Meteran',
            ),
            7 => 
            array (
                'id_sumber_listrik' => 8,
                'sumber_listrik' => 'Listrik Non PLN',
            ),
            8 => 
            array (
                'id_sumber_listrik' => 9,
                'sumber_listrik' => 'Listrik Menumpang',
            ),
            9 => 
            array (
                'id_sumber_listrik' => 10,
                'sumber_listrik' => 'Bukan Listrik',
            ),
        ));
        
        
    }
}