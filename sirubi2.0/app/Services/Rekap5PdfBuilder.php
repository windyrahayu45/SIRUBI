<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\CRuangKeluargaDanTidur;
use App\Models\CJenisFisikBangunan;
use App\Models\CFungsiRumah;
use App\Models\CStatusDtks;
use App\Models\CTipeRumah;

class Rekap5PdfBuilder
{
    public static function build($kecamatanId)
    {
        // Data hasil hitung
        $data = \App\Services\Rekap5Builder::build($kecamatanId);

        // ─────────────────────────────────────────────────────────────
        // MASTER GROUPS
        // ─────────────────────────────────────────────────────────────
        $master = [
            'Ruang Tidur'     => CRuangKeluargaDanTidur::all(['id_ruang_keluarga_dan_tidur','ruang_keluarga_dan_tidur']),
            'Jenis Fisik'     => CJenisFisikBangunan::all(['id_jenis_fisik_bangunan','jenis_fisik_bangunan']),
            'Jumlah Lantai'   => collect([
                (object)['id' => '1', 'label' => '1 Lantai'],
                (object)['id' => '2', 'label' => '2 Lantai'],
                (object)['id' => '3', 'label' => '≥3 Lantai'],
            ]),
            'Fungsi Rumah'    => CFungsiRumah::all(['id_fungsi_rumah','fungsi_rumah']),
            'Tipe Rumah'      => CTipeRumah::all(['id_tipe_rumah','tipe_rumah']),
            'Status DTKS'     => CStatusDtks::all(['id_status_dtks','status_dtks']),
        ];

        // ─────────────────────────────────────────────────────────────
        // FLATTEN COLUMN DEFINITIONS
        // ─────────────────────────────────────────────────────────────
        $flatCols = collect([]);

        // Group A – Ruang Tidur
        foreach ($master['Ruang Tidur'] as $m) {
            $flatCols->push([
                'group' => 'Ruang Tidur',
                'key'   => $m->id_ruang_keluarga_dan_tidur,
                'label' => $m->ruang_keluarga_dan_tidur,
                'prefix'=> 'a_'
            ]);
        }

        // Group B – Jenis Fisik
        foreach ($master['Jenis Fisik'] as $m) {
            $flatCols->push([
                'group' => 'Jenis Fisik',
                'key'   => $m->id_jenis_fisik_bangunan,
                'label' => $m->jenis_fisik_bangunan,
                'prefix'=> 'b_'
            ]);
        }

        // Group C – Jumlah Lantai (3 kolom)
        $flatCols->push([
            'group' => 'Jumlah Lantai',
            'key'   => '1',
            'label' => '1 Lantai',
            'prefix'=> 'c_'
        ]);
        $flatCols->push([
            'group' => 'Jumlah Lantai',
            'key'   => '2',
            'label' => '2 Lantai',
            'prefix'=> 'c_'
        ]);
        $flatCols->push([
            'group' => 'Jumlah Lantai',
            'key'   => '3',
            'label' => '≥3 Lantai',
            'prefix'=> 'c_'
        ]);

        // Group D – Fungsi Rumah
        foreach ($master['Fungsi Rumah'] as $m) {
            $flatCols->push([
                'group' => 'Fungsi Rumah',
                'key'   => $m->id_fungsi_rumah,
                'label' => $m->fungsi_rumah,
                'prefix'=> 'd_'
            ]);
        }

        // Group E – Tipe Rumah
        foreach ($master['Tipe Rumah'] as $m) {
            $flatCols->push([
                'group' => 'Tipe Rumah',
                'key'   => $m->id_tipe_rumah,
                'label' => $m->tipe_rumah,
                'prefix'=> 'e_'
            ]);
        }

        // Group F – Status DTKS
        foreach ($master['Status DTKS'] as $m) {
            $flatCols->push([
                'group' => 'Status DTKS',
                'key'   => $m->id_status_dtks,
                'label' => $m->status_dtks,
                'prefix'=> 'f_'
            ]);
        }


        // ─────────────────────────────────────────────────────────────
        // SPLIT (MAX 12 kolom per halaman)
        // ─────────────────────────────────────────────────────────────
        $maxCols = 12;
        $chunks = $flatCols->chunk($maxCols);

        // ─────────────────────────────────────────────────────────────
        // SUM TOTAL ROW
        // ─────────────────────────────────────────────────────────────
        $rekap5Sum = [];

        foreach ($flatCols as $col) {
            $colName = $col['prefix'] . $col['key'];
            $rekap5Sum[] = $data->sum($colName);
        }

        return [
            'data'      => $data,
            'flatCols'  => $flatCols,
            'chunks'    => $chunks,
            'masters'   => $master,
            'rekap5Sum' => $rekap5Sum,
        ];
    }
}
