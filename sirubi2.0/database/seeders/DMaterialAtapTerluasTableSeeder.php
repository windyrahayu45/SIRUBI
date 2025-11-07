<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DMaterialAtapTerluasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('d_material_atap_terluas')->delete();
        
        DB::table('d_material_atap_terluas')->insert(array (
            0 => 
            array (
                'id_material_atap_terluas' => 1,
                'material_atap_terluas' => 'Genteng',
            ),
            1 => 
            array (
                'id_material_atap_terluas' => 2,
                'material_atap_terluas' => 'Asbes',
            ),
            2 => 
            array (
                'id_material_atap_terluas' => 3,
                'material_atap_terluas' => 'Seng',
            ),
            3 => 
            array (
                'id_material_atap_terluas' => 4,
                'material_atap_terluas' => 'Jerami',
            ),
            4 => 
            array (
                'id_material_atap_terluas' => 5,
                'material_atap_terluas' => 'Ijuk',
            ),
            5 => 
            array (
                'id_material_atap_terluas' => 6,
                'material_atap_terluas' => 'Daun-daun',
            ),
            6 => 
            array (
                'id_material_atap_terluas' => 7,
                'material_atap_terluas' => 'Rumbia',
            ),
            7 => 
            array (
                'id_material_atap_terluas' => 8,
                'material_atap_terluas' => 'Beton',
            ),
            8 => 
            array (
                'id_material_atap_terluas' => 9,
                'material_atap_terluas' => 'Lainnya',
            ),
        ));
        
        
    }
}