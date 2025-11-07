<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CStatusDtksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('c_status_dtks')->delete();
        
        DB::table('c_status_dtks')->insert(array (
            0 => 
            array (
                'id_status_dtks' => 1,
                'status_dtks' => 'Iya',
            ),
            1 => 
            array (
                'id_status_dtks' => 2,
                'status_dtks' => 'Tidak',
            ),
        ));
        
        
    }
}