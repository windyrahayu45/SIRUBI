<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IStatusKepemilikanRumahTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_status_kepemilikan_rumah')->delete();
        
        DB::table('i_status_kepemilikan_rumah')->insert(array (
            0 => 
            array (
                'id_status_kepemilikan_rumah' => 1,
                'status_kepemilikan_rumah' => 'Milik Sendiri',
            ),
            1 => 
            array (
                'id_status_kepemilikan_rumah' => 2,
                'status_kepemilikan_rumah' => 'Bukan Milik Sendiri',
            ),
            2 => 
            array (
                'id_status_kepemilikan_rumah' => 3,
                'status_kepemilikan_rumah' => 'Kontrak/Sewa',
            ),
        ));
        
        
    }
}