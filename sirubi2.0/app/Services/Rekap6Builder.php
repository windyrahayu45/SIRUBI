<?php

namespace App\Services;

use App\Models\FisikRumah;
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

class Rekap6Builder
{
    public static function build($kecamatanId)
    {
        // Ambil master dari DB
        $atap       = DMaterialAtapTerluas::pluck('id_material_atap_terluas');
        $penutup    = DKondisiPenutupAtap::pluck('id_kondisi_penutup_atap');
        $dinding    = DMaterialDindingTerluas::pluck('id_material_dinding_terluas');
        $kondDinding= DKondisiDinding::pluck('id_kondisi_dinding');
        $lantai     = DMaterialLantaiTerluas::pluck('id_material_lantai_terluas');
        $kondLantai = DKondisiLantai::pluck('id_kondisi_lantai');
        $akses      = DAksesKeJalan::pluck('id_akses_ke_jalan');
        $hadapJalan = DBangunanMenghadapJalan::pluck('id_bangunan_menghadap_jalan');
        $hadapSungai= DBangunanMenghadapSungai::pluck('id_bangunan_menghadap_sungai');
        $limbah     = DBangunanBeradaLimbah::pluck('id_bangunan_berada_limbah');
        $sungai     = DBangunanBeradaSungai::pluck('id_bangunan_berada_sungai');

        $select = "
            rumah.kelurahan_id,
            kc.nama_kecamatan,
            kl.nama_kelurahan
        ";

        // A - Material Atap
        foreach ($atap as $id) {
            $select .= ",
                COUNT(CASE WHEN material_atap_terluas_id = {$id} THEN 1 END) as a_{$id}";
        }

        // B - Kondisi Penutup Atap
        foreach ($penutup as $id) {
            $select .= ",
                COUNT(CASE WHEN kondisi_penutup_atap_id = {$id} THEN 1 END) as b_{$id}";
        }

        // C - Material Dinding
        foreach ($dinding as $id) {
            $select .= ",
                COUNT(CASE WHEN material_dinding_terluas_id = {$id} THEN 1 END) as c_{$id}";
        }

        // D - Kondisi Dinding
        foreach ($kondDinding as $id) {
            $select .= ",
                COUNT(CASE WHEN kondisi_dinding_id = {$id} THEN 1 END) as d_{$id}";
        }

        // E - Material Lantai
        foreach ($lantai as $id) {
            $select .= ",
                COUNT(CASE WHEN material_lantai_terluas_id = {$id} THEN 1 END) as e_{$id}";
        }

        // F - Kondisi Lantai
        foreach ($kondLantai as $id) {
            $select .= ",
                COUNT(CASE WHEN kondisi_lantai_id = {$id} THEN 1 END) as f_{$id}";
        }

        // G - Akses ke Jalan
        foreach ($akses as $id) {
            $select .= ",
                COUNT(CASE WHEN akses_ke_jalan_id = {$id} THEN 1 END) as g_{$id}";
        }

        // H - Menghadap Jalan
        foreach ($hadapJalan as $id) {
            $select .= ",
                COUNT(CASE WHEN bangunan_menghadap_jalan_id = {$id} THEN 1 END) as h_{$id}";
        }

        // I - Menghadap Sungai
        foreach ($hadapSungai as $id) {
            $select .= ",
                COUNT(CASE WHEN bangunan_menghadap_sungai_id = {$id} THEN 1 END) as i_{$id}";
        }

        // J - Berada Limbah
        foreach ($limbah as $id) {
            $select .= ",
                COUNT(CASE WHEN bangunan_berada_limbah_id = {$id} THEN 1 END) as j_{$id}";
        }

        // K - Berada Sungai
        foreach ($sungai as $id) {
            $select .= ",
                COUNT(CASE WHEN bangunan_berada_sungai_id = {$id} THEN 1 END) as k_{$id}";
        }

        return FisikRumah::query()
            ->selectRaw($select)
            ->join('rumah', 'fisik_rumah.rumah_id', '=', 'rumah.id_rumah')
            ->join('i_kecamatan as kc', 'rumah.kecamatan_id', '=', 'kc.id_kecamatan')
            ->join('i_kelurahan as kl', 'rumah.kelurahan_id', '=', 'kl.id_kelurahan')
            ->where('rumah.kecamatan_id', $kecamatanId)
            ->groupBy('rumah.kelurahan_id', 'kc.nama_kecamatan', 'kl.nama_kelurahan')
            ->get();
    }
}
