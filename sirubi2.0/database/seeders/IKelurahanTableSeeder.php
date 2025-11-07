<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IKelurahanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('i_kelurahan')->delete();
        
        DB::table('i_kelurahan')->insert(array (
            0 => 
            array (
                'id_kelurahan' => 1,
                'kecamatan_id' => 1,
                'nama_kelurahan' => 'Belakang Balok',
            ),
            1 => 
            array (
                'id_kelurahan' => 2,
                'kecamatan_id' => 1,
                'nama_kelurahan' => 'Birugo',
            ),
            2 => 
            array (
                'id_kelurahan' => 3,
                'kecamatan_id' => 1,
                'nama_kelurahan' => 'Aur Kuning',
            ),
            3 => 
            array (
                'id_kelurahan' => 4,
                'kecamatan_id' => 1,
                'nama_kelurahan' => 'Sapiran',
            ),
            4 => 
            array (
                'id_kelurahan' => 5,
                'kecamatan_id' => 1,
                'nama_kelurahan' => 'Kubu Tanjung',
            ),
            5 => 
            array (
                'id_kelurahan' => 6,
                'kecamatan_id' => 1,
                'nama_kelurahan' => 'Pakan Labuah',
            ),
            6 => 
            array (
                'id_kelurahan' => 7,
                'kecamatan_id' => 1,
                'nama_kelurahan' => 'Ladang Cakiah',
            ),
            7 => 
            array (
                'id_kelurahan' => 8,
                'kecamatan_id' => 1,
                'nama_kelurahan' => 'Parit Antang',
            ),
            8 => 
            array (
                'id_kelurahan' => 9,
                'kecamatan_id' => 2,
                'nama_kelurahan' => 'Kayu Kubu',
            ),
            9 => 
            array (
                'id_kelurahan' => 10,
                'kecamatan_id' => 2,
                'nama_kelurahan' => 'Pakan Kurai',
            ),
            10 => 
            array (
                'id_kelurahan' => 11,
                'kecamatan_id' => 2,
                'nama_kelurahan' => 'Benteng Pasar Atas',
            ),
            11 => 
            array (
                'id_kelurahan' => 12,
                'kecamatan_id' => 2,
                'nama_kelurahan' => 'Bukit Cangang Kayu Ramang',
            ),
            12 => 
            array (
                'id_kelurahan' => 13,
                'kecamatan_id' => 2,
                'nama_kelurahan' => 'Aur Tajungkang Tengah Sawah',
            ),
            13 => 
            array (
                'id_kelurahan' => 14,
                'kecamatan_id' => 2,
                'nama_kelurahan' => 'Tarok Dipo',
            ),
            14 => 
            array (
                'id_kelurahan' => 15,
                'kecamatan_id' => 2,
                'nama_kelurahan' => 'Bukit Apit Puhun',
            ),
            15 => 
            array (
                'id_kelurahan' => 16,
                'kecamatan_id' => 3,
                'nama_kelurahan' => 'Campago Ipuh',
            ),
            16 => 
            array (
                'id_kelurahan' => 17,
                'kecamatan_id' => 3,
                'nama_kelurahan' => 'Campago Guguak Bulek',
            ),
            17 => 
            array (
                'id_kelurahan' => 18,
                'kecamatan_id' => 3,
                'nama_kelurahan' => 'Kubu Gulai Bancah',
            ),
            18 => 
            array (
                'id_kelurahan' => 19,
                'kecamatan_id' => 3,
                'nama_kelurahan' => 'Puhun Tembok',
            ),
            19 => 
            array (
                'id_kelurahan' => 20,
                'kecamatan_id' => 3,
                'nama_kelurahan' => 'Puhun Pintu Kabun',
            ),
            20 => 
            array (
                'id_kelurahan' => 21,
                'kecamatan_id' => 3,
                'nama_kelurahan' => 'Manggis Ganting',
            ),
            21 => 
            array (
                'id_kelurahan' => 22,
                'kecamatan_id' => 3,
                'nama_kelurahan' => 'Pulai Anak Air',
            ),
            22 => 
            array (
                'id_kelurahan' => 23,
                'kecamatan_id' => 3,
                'nama_kelurahan' => 'Garegeh',
            ),
            23 => 
            array (
                'id_kelurahan' => 24,
                'kecamatan_id' => 3,
                'nama_kelurahan' => 'Koto Selayan',
            ),
        ));
        
        
    }
}