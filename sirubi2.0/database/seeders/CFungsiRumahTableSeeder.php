<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CFungsiRumahTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('c_fungsi_rumah')->delete();
        
        DB::table('c_fungsi_rumah')->insert(array (
            0 => 
            array (
                'id_fungsi_rumah' => 1,
                'fungsi_rumah' => 'Campuran = Rumah dan Kos-kosan',
            ),
            1 => 
            array (
                'id_fungsi_rumah' => 2,
                'fungsi_rumah' => 'Campuran = Rumah dan Toko',
            ),
            2 => 
            array (
                'id_fungsi_rumah' => 3,
                'fungsi_rumah' => 'Campuran = Rumah dan Warung',
            ),
            3 => 
            array (
                'id_fungsi_rumah' => 4,
                'fungsi_rumah' => 'Campuran = Rumah dan Kantor',
            ),
            4 => 
            array (
                'id_fungsi_rumah' => 5,
                'fungsi_rumah' => 'Rumah Tunggal',
            ),
        ));
        
        
    }
}