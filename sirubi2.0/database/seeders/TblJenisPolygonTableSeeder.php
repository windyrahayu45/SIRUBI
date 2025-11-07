<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TblJenisPolygonTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('tbl_jenis_polygon')->delete();
        
        DB::table('tbl_jenis_polygon')->insert(array (
            0 => 
            array (
                'id_jenis_polygon' => 1,
                'jenis_polygon' => 'Kawasan Kumuh',
            ),
            1 => 
            array (
                'id_jenis_polygon' => 2,
                'jenis_polygon' => 'Kawasan Permukiman',
            ),
            2 => 
            array (
                'id_jenis_polygon' => 3,
                'jenis_polygon' => 'Kawasan Rawan Bencana',
            ),
        ));
        
        
    }
}