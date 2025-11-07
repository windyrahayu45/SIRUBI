<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DMaterialLantaiTerluasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_material_lantai_terluas')->delete();
        
        DB::table('d_material_lantai_terluas')->insert(array (
            0 => 
            array (
                'id_material_lantai_terluas' => 1,
                'material_lantai_terluas' => 'Marmer/Granit',
            ),
            1 => 
            array (
                'id_material_lantai_terluas' => 2,
                'material_lantai_terluas' => 'Keramik',
            ),
            2 => 
            array (
                'id_material_lantai_terluas' => 3,
                'material_lantai_terluas' => 'Ubin/Tegel',
            ),
            3 => 
            array (
                'id_material_lantai_terluas' => 4,
                'material_lantai_terluas' => 'Plesteran',
            ),
            4 => 
            array (
                'id_material_lantai_terluas' => 5,
                'material_lantai_terluas' => 'Kayu / Papan',
            ),
            5 => 
            array (
                'id_material_lantai_terluas' => 6,
                'material_lantai_terluas' => 'Bambu',
            ),
            6 => 
            array (
                'id_material_lantai_terluas' => 7,
                'material_lantai_terluas' => 'Tanah',
            ),
        ));
        
        
    }
}