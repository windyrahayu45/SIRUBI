<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IBuktiKepemilikanTanahTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_bukti_kepemilikan_tanah')->delete();
        
        DB::table('i_bukti_kepemilikan_tanah')->insert(array (
            0 => 
            array (
                'id_bukti_kepemilikan_tanah' => 1,
                'bukti_kepemilikan_tanah' => 'Hak Milik',
            ),
            1 => 
            array (
                'id_bukti_kepemilikan_tanah' => 2,
                'bukti_kepemilikan_tanah' => 'HGB',
            ),
            2 => 
            array (
                'id_bukti_kepemilikan_tanah' => 3,
                'bukti_kepemilikan_tanah' => 'Girik/Letter C',
            ),
            3 => 
            array (
                'id_bukti_kepemilikan_tanah' => 4,
                'bukti_kepemilikan_tanah' => 'Tanah Adat',
            ),
            4 => 
            array (
                'id_bukti_kepemilikan_tanah' => 5,
                'bukti_kepemilikan_tanah' => 'Keterangan Lain',
            ),
        ));
        
        
    }
}