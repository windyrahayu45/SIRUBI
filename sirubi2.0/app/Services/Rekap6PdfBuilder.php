<?php

namespace App\Services;

use App\Models\DMaterialAtapTerluas;
use App\Models\DKondisiPenutupAtap;
use App\Models\DMaterialDindingTerluas;
use App\Models\DKondisiDinding;
use App\Models\DMaterialLantaiTerluas;
use App\Models\DKondisiLantai;
use App\Models\DAksesKeJalan;
use App\Models\DBangunanMenghadapJalan;
use App\Models\DBangunanMenghadapSungai;
use App\Models\DBangunanBeradaLimbah;
use App\Models\DBangunanBeradaSungai;

class Rekap6PdfBuilder
{
    public static function build($kecamatanId)
    {
        $data = \App\Services\Rekap6Builder::build($kecamatanId);

        // ─────────────────────────────────────────────
        // MASTER GROUPS
        // ─────────────────────────────────────────────
        $masters = [
            'A. Material Atap' => DMaterialAtapTerluas::all(['id_material_atap_terluas','material_atap_terluas']),
            'B. Kondisi Atap'  => DKondisiPenutupAtap::all(['id_kondisi_penutup_atap','kondisi_penutup_atap']),
            'C. Material Dinding' => DMaterialDindingTerluas::all(['id_material_dinding_terluas','material_dinding_terluas']),
            'D. Kondisi Dinding'  => DKondisiDinding::all(['id_kondisi_dinding','kondisi_dinding']),
            'E. Material Lantai'  => DMaterialLantaiTerluas::all(['id_material_lantai_terluas','material_lantai_terluas']),
            'F. Kondisi Lantai'   => DKondisiLantai::all(['id_kondisi_lantai','kondisi_lantai']),
            'G. Akses Jalan'      => DAksesKeJalan::all(['id_akses_ke_jalan','akses_ke_jalan']),
            'H. Menghadap Jalan'  => DBangunanMenghadapJalan::all(['id_bangunan_menghadap_jalan','bangunan_menghadap_jalan']),
            'I. Menghadap Sungai' => DBangunanMenghadapSungai::all(['id_bangunan_menghadap_sungai','bangunan_menghadap_sungai']),
            'J. Berada Limbah'    => DBangunanBeradaLimbah::all(['id_bangunan_berada_limbah','bangunan_berada_limbah']),
            'K. Berada Sungai'    => DBangunanBeradaSungai::all(['id_bangunan_berada_sungai','bangunan_berada_sungai']),
        ];

        // PREFIX mapping
        $prefix = [
            'A. Material Atap' => 'a_',
            'B. Kondisi Atap'  => 'b_',
            'C. Material Dinding' => 'c_',
            'D. Kondisi Dinding'  => 'd_',
            'E. Material Lantai'  => 'e_',
            'F. Kondisi Lantai'   => 'f_',
            'G. Akses Jalan'      => 'g_',
            'H. Menghadap Jalan'  => 'h_',
            'I. Menghadap Sungai' => 'i_',
            'J. Berada Limbah'    => 'j_',
            'K. Berada Sungai'    => 'k_',
        ];

        // ─────────────────────────────────────────────
        // FLATTEN COLUMN DEFINITIONS
        // ─────────────────────────────────────────────
        $flatCols = collect([]);

       foreach ($masters as $group => $items) {
        foreach ($items as $item) {

            // Cari field ID (field yang diawali id_)
            $idField = null;
            foreach ($item->getAttributes() as $key => $val) {
                if (str_starts_with($key, 'id_')) {
                    $idField = $val;
                    break;
                }
            }

            // Cari field label (bukan id_)
            $label = null;
            foreach ($item->getAttributes() as $key => $val) {
                if (!str_starts_with($key, 'id_')) {
                    $label = $val;
                    break;
                }
            }

            $flatCols->push([
                'group'  => $group,
                'key'    => $idField,
                'label'  => $label,
                'prefix' => $prefix[$group]
            ]);
        }
    }


        // ─────────────────────────────────────────────
        // SPLIT MAX 12 COL
        // ─────────────────────────────────────────────
        $maxCols = 12;
        $chunks  = $flatCols->chunk($maxCols);

        // ─────────────────────────────────────────────
        // TOTAL
        // ─────────────────────────────────────────────
        $sum = [];
        foreach ($flatCols as $col) {
            $colName = $col['prefix'].$col['key'];
            $sum[] = $data->sum($colName);
        }

        return [
            'data'     => $data,
            'masters'  => $masters,
            'flatCols' => $flatCols,
            'chunks'   => $chunks,
            'rekap6Sum'=> $sum,
        ];
    }
}
