<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IStatusKepemilikanTanahTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_status_kepemilikan_tanah')->delete();
        
        DB::table('i_status_kepemilikan_tanah')->insert(array (
            0 => 
            array (
                'id_status_kepemilikan_tanah' => 1,
                'status_kepemilikan_tanah' => 'Milik Sendiri',
            ),
            1 => 
            array (
                'id_status_kepemilikan_tanah' => 2,
                'status_kepemilikan_tanah' => 'Bukan Milik Sendiri',
            ),
            2 => 
            array (
                'id_status_kepemilikan_tanah' => 3,
                'status_kepemilikan_tanah' => 'Sewa',
            ),
            3 => 
            array (
                'id_status_kepemilikan_tanah' => 4,
                'status_kepemilikan_tanah' => 'Milik Negara',
            ),
        ));
        
        
    }
}