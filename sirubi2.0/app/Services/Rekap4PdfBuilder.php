<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Rekap4Builder;

class Rekap4PdfBuilder
{
    public static function build($kecamatanId)
    {
        // Ambil data utama (sudah berisi kolom a_, b_, c_, d_, dst)
        $data = Rekap4Builder::build($kecamatanId);

        // ===============================
        // MASTER GROUPS UNTUK LABEL HEADER
        // ===============================
        $masterGroups = [
            'Jendela'               => DB::table('b_jendela_lubang_cahaya')->pluck('jendela_lubang_cahaya', 'id_jendela_lubang_cahaya'),
            'Kondisi Jendela'       => DB::table('b_kondisi_jendela_lubang_cahaya')->pluck('kondisi_jendela_lubang_cahaya', 'id_kondisi_jendela_lubang_cahaya'),

            'Ventilasi'             => DB::table('b_ventilasi')->pluck('ventilasi', 'id_ventilasi'),
            'Kondisi Ventilasi'     => DB::table('b_kondisi_ventilasi')->pluck('kondisi_ventilasi', 'id_kondisi_ventilasi'),

            'Kamar Mandi'           => DB::table('b_kamar_mandi')->pluck('kamar_mandi', 'id_kamar_mandi'),
            'Kondisi KM'            => DB::table('b_kondisi_kamar_mandi')->pluck('kondisi_kamar_mandi', 'id_kondisi_kamar_mandi'),

            'Jamban'                => DB::table('b_jamban')->pluck('jamban', 'id_jamban'),
            'Kondisi Jamban'        => DB::table('b_kondisi_jamban')->pluck('kondisi_jamban', 'id_kondisi_jamban'),

            'SPAL'                  => DB::table('b_sistem_pembuangan_air_kotor')->pluck('sistem_pembuangan_air_kotor', 'id_sistem_pembuangan_air_kotor'),
            'Kondisi SPAL'          => DB::table('b_kondisi_sistem_pembuangan_air_kotor')->pluck('kondisi_sistem_pembuangan_air_kotor', 'id_kondisi_sistem_pembuangan_air_kotor'),

            'Frekuensi Sedot'       => DB::table('b_frekuensi_penyedotan')->pluck('frekuensi_penyedotan', 'id_frekuensi_penyedotan'),

            'Air Minum'             => DB::table('b_sumber_air_minum')->pluck('sumber_air_minum', 'id_sumber_air_minum'),
            'Kondisi Air'           => DB::table('b_kondisi_sumber_air_minum')->pluck('kondisi_sumber_air_minum', 'id_kondisi_sumber_air_minum'),

            'Listrik'               => DB::table('b_sumber_listrik')->pluck('sumber_listrik', 'id_sumber_listrik'),
        ];

        // ===============================
        // FLATTEN KOLOM DYNAMIC
        // ===============================
        $flatCols = collect([]);

        foreach ($masterGroups as $group => $cols) {
            foreach ($cols as $key => $label) {
                $flatCols->push([
                    'group' => $group,
                    'key'   => $key,
                    'label' => $label
                ]);
            }
        }

        // ===============================
        // SPLIT KOLOM (max 12 kolom per halaman)
        // ===============================
        $maxCols = 12;
        $chunks = $flatCols->chunk($maxCols);

        // ===============================
        // HITUNG TOTAL
        // ===============================
        $rekap4Sum = [];

        foreach ($flatCols as $col) {

            $colName = match ($col['group']) {
                'Jendela'           => "a_"  . $col['key'],
                'Kondisi Jendela'   => "b_"  . $col['key'],

                'Ventilasi'         => "c_"  . $col['key'],
                'Kondisi Ventilasi' => "d_"  . $col['key'],

                'Kamar Mandi'       => "e_"  . $col['key'],
                'Kondisi KM'        => "f_"  . $col['key'],

                'Jamban'            => "g_"  . $col['key'],
                'Kondisi Jamban'    => "h_"  . $col['key'],

                'SPAL'              => "i_"  . $col['key'],
                'Kondisi SPAL'      => "j_"  . $col['key'],

                'Frekuensi Sedot'   => "ia_" . $col['key'],

                'Air Minum'         => "k_"  . $col['key'],
                'Kondisi Air'       => "ka_" . $col['key'],

                'Listrik'           => "l_"  . $col['key'],
            };

            $rekap4Sum[] = $data->sum($colName) ?? 0;
        }

        return [
            'data'      => $data,
            'masters'   => $masterGroups,
            'flatCols'  => $flatCols,
            'chunks'    => $chunks,
            'rekap4Sum' => $rekap4Sum,
        ];
    }
}
