<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IPendidikanTerakhirTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_pendidikan_terakhir')->delete();
        
        DB::table('i_pendidikan_terakhir')->insert(array (
            0 => 
            array (
                'id_pendidikan_terakhir' => 1,
                'pendidikan_terakhir' => 'Tidak Punya Ijazah',
            ),
            1 => 
            array (
                'id_pendidikan_terakhir' => 2,
                'pendidikan_terakhir' => 'SD/Sederajat',
            ),
            2 => 
            array (
                'id_pendidikan_terakhir' => 3,
                'pendidikan_terakhir' => 'SMP/Sederajat',
            ),
            3 => 
            array (
                'id_pendidikan_terakhir' => 4,
                'pendidikan_terakhir' => 'SMA/Sederajat',
            ),
            4 => 
            array (
                'id_pendidikan_terakhir' => 5,
                'pendidikan_terakhir' => 'D1/D2/D3',
            ),
            5 => 
            array (
                'id_pendidikan_terakhir' => 6,
                'pendidikan_terakhir' => 'D4/S1',
            ),
            6 => 
            array (
                'id_pendidikan_terakhir' => 7,
                'pendidikan_terakhir' => 'S2',
            ),
            7 => 
            array (
                'id_pendidikan_terakhir' => 8,
                'pendidikan_terakhir' => 'S3',
            ),
        ));
        
        
    }
}