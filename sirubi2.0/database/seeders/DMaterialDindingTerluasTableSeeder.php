<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DMaterialDindingTerluasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_material_dinding_terluas')->delete();
        
        DB::table('d_material_dinding_terluas')->insert(array (
            0 => 
            array (
                'id_material_dinding_terluas' => 1,
                'material_dinding_terluas' => 'Tembok Plesteran',
            ),
            1 => 
            array (
                'id_material_dinding_terluas' => 2,
                'material_dinding_terluas' => 'Tembok Tanpa Plesteran',
            ),
            2 => 
            array (
                'id_material_dinding_terluas' => 3,
                'material_dinding_terluas' => 'GRC/Asbes',
            ),
            3 => 
            array (
                'id_material_dinding_terluas' => 4,
                'material_dinding_terluas' => 'Kayu/Papan',
            ),
            4 => 
            array (
                'id_material_dinding_terluas' => 5,
                'material_dinding_terluas' => 'Plesteran Anyaman Bambu',
            ),
            5 => 
            array (
                'id_material_dinding_terluas' => 6,
                'material_dinding_terluas' => 'Anyaman Bambu/Bilik',
            ),
            6 => 
            array (
                'id_material_dinding_terluas' => 7,
                'material_dinding_terluas' => 'Bambu',
            ),
            7 => 
            array (
                'id_material_dinding_terluas' => 8,
                'material_dinding_terluas' => 'Rumbia',
            ),
            8 => 
            array (
                'id_material_dinding_terluas' => 9,
                'material_dinding_terluas' => 'Batang Kayu',
            ),
            9 => 
            array (
                'id_material_dinding_terluas' => 10,
                'material_dinding_terluas' => 'Lainnya',
            ),
        ));
        
        
    }
}