<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CTipeRumahTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('c_tipe_rumah')->delete();
        
        DB::table('c_tipe_rumah')->insert(array (
            0 => 
            array (
                'id_tipe_rumah' => 1,
                'tipe_rumah' => 'Permanen',
            ),
            1 => 
            array (
                'id_tipe_rumah' => 2,
                'tipe_rumah' => 'Semi Permanen',
            ),
            2 => 
            array (
                'id_tipe_rumah' => 3,
                'tipe_rumah' => 'Rumah Panggung',
            ),
            3 => 
            array (
                'id_tipe_rumah' => 4,
                'tipe_rumah' => 'Rumah Kayu',
            ),
        ));
        
        
    }
}